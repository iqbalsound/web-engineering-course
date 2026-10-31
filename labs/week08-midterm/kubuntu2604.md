# Week 8 lab: Mid-Term Practical Environment and Automatic Checker – Kubuntu 26.04 LTS

## Step 1 – Create exam folders and permissions

Each student owns a folder; www-data can read it.

```bash
sudo mkdir -p /var/www/webeng/mid && sudo chown $USER:www-data /var/www/webeng/mid
for r in 24-001 24-002; do mkdir -p /var/www/webeng/mid/$r; done
chmod -R g+rX /var/www/webeng/mid
```

## Step 2 – Install the checker

html-validate is installed once in a helper project.

```bash
mkdir -p ~/webeng/mid-check && cd ~/webeng/mid-check
npm init -y && npm install --save-dev html-validate
echo '{ "extends": ["html-validate:recommended"] }' > .htmlvalidate.json
kate check.sh && chmod +x check.sh
```

## Step 3 – Pre-test with the model solution

Copy the model answer into a test roll number and run the checker.

```bash
cp -r ~/webeng/model/* /var/www/webeng/mid/24-001/
./check.sh 24-001 | tee /var/www/webeng/mid/24-001/report.txt
```

## Step 4 – Collect submissions

Each student commits in their folder; the instructor archives all folders.

```bash
cd /var/www/webeng/mid/24-001 && git init -q && git add . && git commit -qm "Mid-term submission 24-001"
tar czf ~/mid-submissions.tgz -C /var/www/webeng mid && sha256sum ~/mid-submissions.tgz
```
