import { readFileSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = dirname(dirname(fileURLToPath(import.meta.url)));
const snapshot = JSON.parse(readFileSync(join(root, 'resources/endpoints.json'), 'utf8'));
const groups = {
    account: ['Accounts', 'accounts'], tanks: ['Tanks', 'tanks'],
    encyclopedia: ['Encyclopedia', 'encyclopedia'], clans: ['Clans', 'clans'],
    clanratings: ['ClanRatings', 'clanRatings'], globalmap: ['GlobalMap', 'globalMap'],
    stronghold: ['Stronghold', 'stronghold'], ratings: ['Ratings', 'ratings'],
};
const names = {
    list: 'search', claninfo: 'clanInfo', clanreserves: 'clanReserves',
    activateclanreserve: 'activateClanReserve', clanprovinces: 'clanProvinces',
    clanbattles: 'clanBattles', seasonclaninfo: 'seasonClanInfo',
    seasonaccountinfo: 'seasonAccountInfo', seasonrating: 'seasonRating',
    seasonratingneighbors: 'seasonRatingNeighbors', eventclaninfo: 'eventClanInfo',
    eventaccountinfo: 'eventAccountInfo', eventaccountratings: 'eventAccountRatings',
    eventaccountratingneighbors: 'eventAccountRatingNeighbors', eventrating: 'eventRating',
    eventratingneighbors: 'eventRatingNeighbors', vehicleprofile: 'vehicleProfile',
    vehicleprofiles: 'vehicleProfiles', personalmissions: 'personalMissions',
    crewroles: 'crewRoles', crewskills: 'crewSkills', tankinfo: 'tankInfo',
    tankengines: 'tankEngines', tankturrets: 'tankTurrets', tankradios: 'tankRadios',
    tankchassis: 'tankChassis', tankguns: 'tankGuns', accountinfo: 'accountInfo',
    messageboard: 'messageboard', memberhistory: 'memberHistory',
};

function parameter(name, schema) {
    let variable = name.replace(/_([a-z])/g, (_, letter) => letter.toUpperCase());
    const list = schema.type.includes(', list');
    if (list && name.endsWith('_id')) variable += 's';
    const type = list ? 'array' : schema.type === 'numeric' ? 'int' : schema.type === 'timestamp/date' ? 'int|string' : 'string';
    const signature = schema.required ? `${type} $${variable}` : list ? `array $${variable} = []` : `${type}|null $${variable} = null`;
    return { name, variable, type, list, required: schema.required, signature: name === 'access_token' ? `#[SensitiveParameter] ${signature}` : signature };
}

function sample(parameter, schema) {
    if (parameter.list) {
        if (schema.choices.length) return `[${JSON.stringify(String(schema.choices[0])).replaceAll('$', '\\$')}]`;
        if (parameter.name === 'percentile') return '[95]';
        return schema.type.startsWith('numeric') ? '[500000001]' : "['example']";
    }
    if (schema.type === 'numeric') return '1';
    if (schema.type === 'timestamp/date') return 'time()';
    if (schema.choices.length) return `'${String(schema.choices[0]).replaceAll("'", "\\'")}'`;
    if (parameter.name === 'search') return "'Player'";
    return "'example'";
}

const reference = [
    '# World of Tanks GET methods', '',
    `API namespace: \`wot\`. Catalog snapshot: ${snapshot.checkedAt}. Each method below returns a list of raw per-URL FetchResult objects; it never parses WG JSON.`,
    'For ID-list methods, pass K as `batchSize`. The caller chooses K; the client only divides N values into groups of at most K.',
    'Every service method also has a `prepareX()` form with the same arguments for mixed-method `executeMany()` calls. Static facades have the same signatures.', '',
    'For methods supporting `language`, the request argument overrides the client default. `setLanguage()` changes the default for future calls; prepared operations retain the language resolved at preparation time. See the README for instance and static configuration examples.', '',
    'Methods marked **Deprecated** in the bundled WG catalog remain callable. The label is informational; the client returns their raw HTTP results as usual.', '',
];
const endpointTable = [
    '# World of Tanks GET endpoint catalog', '',
    `Snapshot: ${snapshot.checkedAt}. Authentication is handled independently by WgAuth. POST methods are outside this GET client.`, '',
    'Deprecated methods remain callable; the label does not establish their current availability at WG.', '',
    '| Path | Instance method | K required | Deprecated |', '| --- | --- | --- | --- |',
];

for (const [section, [className, accessor]] of Object.entries(groups)) {
    for (const facade of [false, true]) {
        const namespace = facade ? 'Facades' : 'Services';
        const lines = [
            '<?php', '', 'declare(strict_types=1);', '',
            `namespace edrard\\WotClient\\${namespace};`, '',
            'use edrard\\WotClient\\PreparedOperation;',
            'use edrard\\WgGetter\\FetchResult;',
            'use SensitiveParameter;', '',
            '/** Generated from resources/endpoints.json by tools/generate-client.mjs. */',
            `final ${facade ? 'class' : 'readonly class'} ${className}${facade ? '' : ' extends Service'}`, '{',
        ];
        for (const [path, endpoint] of Object.entries(snapshot.endpoints)) {
            if (!path.startsWith(`${section}/`) || endpoint.write || !endpoint.httpMethods.includes('GET')) continue;
            const slug = path.split('/')[1];
            const methodName = names[slug] ?? slug;
            const entries = Object.entries(endpoint.parameters).filter(([name]) => name !== 'application_id');
            entries.sort((a, b) => Number(b[1].required) - Number(a[1].required));
            const parameters = entries.map(([name, schema]) => parameter(name, schema));
            const required = parameters.filter(p => p.required);
            const optional = parameters.filter(p => !p.required);
            const signature = [...required.map(p => p.signature), ...(endpoint.batchParameter ? ['int $batchSize'] : []), ...optional.map(p => p.signature)];
            const args = [...required, ...optional];
            const invocation = args.map(p => `$${p.variable}`).join(', ');
            for (const prepare of [false, true]) {
                const name = prepare ? `prepare${methodName[0].toUpperCase()}${methodName.slice(1)}` : methodName;
                lines.push('    /**');
                lines.push(`     * ${path}. ${prepare ? 'Prepare without HTTP I/O.' : 'Return one raw result per URL.'}`);
                if (endpoint.deprecated) lines.push('     * @deprecated Marked deprecated in the WG catalog; requests remain available.');
                for (const p of args.filter(p => p.list)) {
                    const schema = endpoint.parameters[p.name];
                    lines.push(`     * @param list<${schema.type.startsWith('numeric') ? 'int' : 'string'}> $${p.variable}`);
                }
                if (!prepare) lines.push('     * @return list<FetchResult>');
                lines.push('     */');
                lines.push(`    public ${facade ? 'static ' : ''}function ${name}(`);
                for (const item of signature) lines.push(`        ${item},`);
                lines.push(`    ): ${prepare ? 'PreparedOperation' : 'array'} {`);
                if (facade) {
                    const parametersToPass = [...required.map(p => `$${p.variable}`), ...(endpoint.batchParameter ? ['$batchSize'] : []), ...optional.map(p => `$${p.variable}`)];
                    lines.push(`        return Wot::client()->${accessor}()->${name}(${parametersToPass.join(', ')});`);
                } else {
                    lines.push(`        return $this->client->${prepare ? 'prepare' : 'request'}(`);
                    lines.push(`            '${path}',`);
                    lines.push('            [');
                    for (const p of args) lines.push(`                '${p.name}' => $${p.variable},`);
                    lines.push('            ],');
                    lines.push(`            ${endpoint.batchParameter ? '$batchSize' : 'null'},`);
                    lines.push('        );');
                }
                lines.push('    }', '');
            }
            if (!facade) {
                const sampleArgs = required.map(p => `${p.variable}: ${sample(p, endpoint.parameters[p.name])}`);
                if (endpoint.batchParameter) sampleArgs.push('batchSize: 25');
                endpointTable.push(`| [${path}](https://developers.wargaming.net/reference/all/wot/${path}/) | \`${accessor}()->${methodName}()\` | ${endpoint.batchParameter ? 'Yes' : 'No'} | ${endpoint.deprecated ? '**Deprecated**' : 'No'} |`);
                reference.push(`## ${path}`, '');
                reference.push(`Catalog realms: ${endpoint.realms.join(', ')}.`, '');
                if (endpoint.deprecated) reference.push('**Deprecated:** marked deprecated in the WG catalog. This method remains callable and returns raw HTTP results.', '');
                reference.push(`Instance: \`$client->${accessor}()->${methodName}(${sampleArgs.join(', ')})\``, '',
                    `Static: \`${className}::${methodName}(${sampleArgs.join(', ')})\``, '',
                    `Signature: \`${methodName}(${signature.join(', ')}): array\``, '',
                    `Official reference: https://developers.wargaming.net/reference/all/wot/${path}/`, '',
                    '| WG parameter | Named argument | Required | Type / constraints |',
                    '| --- | --- | --- | --- |');
                for (const p of parameters) {
                    const schema = endpoint.parameters[p.name];
                    const constraints = [schema.type];
                    if (schema.choices.length) constraints.push(`values: ${schema.choices.join(', ')}`);
                    if (schema.type.startsWith('numeric')) {
                        const minimum = schema.min ?? ((p.name.endsWith('_id') || ['page_no', 'limit', 'tier', 'reserve_level'].includes(p.name)) ? 1 : 0);
                        constraints.push(`min: ${minimum}`);
                    }
                    if (schema.max !== null) constraints.push(`max: ${schema.max}`);
                    if (schema.minLength !== null) constraints.push(`min bytes: ${schema.minLength}`);
                    if (schema.maxLength !== null) constraints.push(`max bytes: ${schema.maxLength}`);
                    if (schema.maxItems !== null) constraints.push(`${p.name === endpoint.batchParameter ? 'WG list limit (caller chooses K)' : 'max items'}: ${schema.maxItems}`);
                    reference.push(`| \`${p.name}\` | \`${p.variable}\` | ${p.required ? 'Yes' : 'No'} | ${constraints.join('; ')} |`);
                }
                if (endpoint.batchParameter) reference.push('| Client grouping | `batchSize` | Yes | Positive integer K, chosen by caller. |');
                reference.push('');
            }
            if (path === 'account/list') {
                for (const prepare of [false, true]) {
                    const name = prepare ? 'prepareSearchExactMany' : 'searchExactMany';
                    lines.push('    /**');
                    lines.push('     * Split N exact nicknames into URL groups of caller-supplied K.');
                    lines.push('     * @param list<string> $names');
                    lines.push('     * @param list<string> $fields');
                    if (!prepare) lines.push('     * @return list<FetchResult>');
                    lines.push('     */');
                    lines.push(`    public ${facade ? 'static ' : ''}function ${name}(`);
                    lines.push('        array $names,', '        int $batchSize,', '        string|null $language = null,', '        array $fields = [],', '        int|null $limit = null,');
                    lines.push(`    ): ${prepare ? 'PreparedOperation' : 'array'} {`);
                    if (facade) {
                        lines.push(`        return Wot::client()->accounts()->${name}($names, $batchSize, $language, $fields, $limit);`);
                    } else {
                        lines.push(`        return $this->client->${prepare ? 'prepare' : 'request'}(`);
                        lines.push("            'account/list',");
                        lines.push("            ['search' => $names, 'type' => 'exact', 'language' => $language, 'fields' => $fields, 'limit' => $limit],");
                        lines.push('            $batchSize,');
                        lines.push('        );');
                    }
                    lines.push('    }', '');
                }
                if (!facade) reference.push('## account/list: exact nickname batch', '',
                    'Instance: `$client->accounts()->searchExactMany([\'PlayerOne\', \'PlayerTwo\'], batchSize: 2)`', '',
                    'Static: `Accounts::searchExactMany([\'PlayerOne\', \'PlayerTwo\'], batchSize: 2)`', '',
                    'The client splits the names by K and sends the resulting URLs in one getter multirequest.', '');
            }
        }
        lines.push('}', '');
        writeFileSync(join(root, 'src', namespace, `${className}.php`), lines.join('\n'));
    }
}
writeFileSync(join(root, 'docs', 'ENDPOINTS.md'), endpointTable.join('\n').trimEnd() + '\n');
writeFileSync(join(root, 'docs', 'METHODS.md'), reference.join('\n').trimEnd() + '\n');
console.log('Generated GET services, facades and method documentation.');
