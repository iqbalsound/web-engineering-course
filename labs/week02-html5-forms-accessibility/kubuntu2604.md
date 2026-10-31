# Week 2 lab: Accessible Student Registration Form with Automated Linting – Kubuntu 26.04 LTS

## Step 1 – Create the folder and the files

Save the two files above.

```bash
mkdir -p /var/www/webeng/week02 && cd /var/www/webeng/week02
kate register.html thanks.html &
```

## Step 2 – Initialise a Node project with tooling

Dev dependencies stay local to the project.

```bash
npm init -y
npm install --save-dev html-validate prettier
npx prettier --write "*.html"
```

## Step 3 – Create the validator configuration

Extends the recommended rule set and adds accessibility rules.

```bash
cat > .htmlvalidate.json <<'EOF'
{ "extends": ["html-validate:recommended", "html-validate:a11y"] }
EOF
npx html-validate register.html thanks.html
```

## Step 4 – Test in the browser

Use Tab only, no mouse, and open the accessibility inspector.

```bash
firefox http://webeng.test/week02/register.html &
# Firefox: F12 → Accessibility tab → Check for issues
```

## Step 5 – Verify the server side

Confirm GET puts the data in the query string; check Apache access log.

```bash
curl -s "http://webeng.test/week02/thanks.html?name=Ali&cnic=42101-1234567-1" | head -n 3
sudo tail -n 3 /var/log/apache2/webeng_access.log
```
