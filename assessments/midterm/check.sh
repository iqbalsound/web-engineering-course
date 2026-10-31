#!/usr/bin/env bash
# usage: ./check.sh <rollno>      (run from ~/webeng/mid-check, project must have html-validate installed)
set -u
ROLL=${1:?rollno required}; DIR=/var/www/webeng/mid/$ROLL; URL=http://webeng.test/mid/$ROLL/
score=0; ok(){ echo "PASS  $1"; score=$((score+$2)); }; bad(){ echo "FAIL  $1"; }
[ "$(curl -s -o /dev/null -w '%{http_code}' $URL)" = 200 ] && ok "page served (HTTP 200)" 0 || bad "page not served"
H=$(curl -s $URL)
for t in header nav main footer; do grep -qi "<$t" <<<"$H" && ok "<$t> present" 0 || bad "<$t> missing"; done
[ "$(grep -io '<h1' <<<"$H" | wc -l)" = 1 ] && ok "exactly one h1" 0 || bad "h1 count"
grep -qi 'required' <<<"$H" && grep -qi 'type="number"' <<<"$H" && ok "form attributes" 1 || bad "form attributes"
grep -Eq 'display: *grid|display:grid' $DIR/*.css && ok "CSS grid used" 1 || bad "no grid"
grep -Eq '@media' $DIR/*.css && ok "media query used" 1 || bad "no media query"
grep -Eq 'addEventListener' $DIR/*.js && ok "JS event listener" 1 || bad "no JS listener"
grep -Eq 'innerHTML' $DIR/*.js && bad "innerHTML used (XSS risk)" || ok "no innerHTML" 1
(cd ~/webeng/mid-check && npx html-validate "$DIR/index.html" >/dev/null 2>&1) && ok "html-validate clean" 1 || bad "html-validate errors"
echo "Automatic score: $score (instructor adds manual marks)"
