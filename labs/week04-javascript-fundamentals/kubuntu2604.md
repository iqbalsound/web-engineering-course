# Week 4 lab: Expense Tracker – Tested ES Module Library with a Browser UI – Kubuntu 26.04 LTS

## Step 1 – Create the project

ES modules need `"type": "module"` in package.json.

```bash
mkdir -p /var/www/webeng/week04 && cd /var/www/webeng/week04
npm init -y && npm pkg set type=module
npm install --save-dev eslint @eslint/js prettier
kate expenses.js expenses.test.js app.js index.html &
```

## Step 2 – Configure ESLint (flat config)

ESLint 9 uses eslint.config.js.

```bash
cat > eslint.config.js <<'EOF'
import js from '@eslint/js';
export default [js.configs.recommended,
  { languageOptions: { globals: { document: 'readonly', alert: 'readonly', FormData: 'readonly' } } }];
EOF
```

## Step 3 – Run tests and lint

Tests first, then static analysis, then formatting.

```bash
node --test
npx eslint .
npx prettier --check .
```

## Step 4 – Publish

Apache serves modules with the correct MIME type (text/javascript).

```bash
curl -sI http://webeng.test/week04/app.js | grep -i content-type
firefox http://webeng.test/week04/ &
```

## Step 5 – Debug in DevTools

Set a breakpoint inside the submit handler and watch `expenses`.

```bash
# Firefox: F12 → Debugger → app.js → click line number → submit the form
```
