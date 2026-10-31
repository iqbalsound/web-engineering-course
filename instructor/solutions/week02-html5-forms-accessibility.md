# Week 2 solutions: HTML5 Forms and Accessibility

## Expected results and evidence
| Check | Expected result / model evidence |
| --- | --- |
| `npx html-validate register.html thanks.html` | No output and exit code 0 (`echo $?` prints 0) |
| Invalid CNIC `1234` | Browser bubble: “Please match the requested format” (pattern attribute) |
| Valid submit | URL becomes `thanks.html?name=...&email=...&cnic=...&mobile=...&dob=...&dept=...&sem=5&gpa=3&terms=on` |
| Accessibility inspector | Landmarks: banner, navigation, main, contentinfo; no “missing label” warnings |
| Keyboard test | Skip link is the first Tab stop; every control reachable; focus ring visible |

**Typical html-validate findings and fixes**

```
no-implicit-button-type   -> <button type="submit">
input-missing-label       -> add <label for="id"> or wrap the input
no-inline-style           -> move style="" into a stylesheet
wcag/h30 (link text)      -> give links meaningful text, not "click here"
```

**Better thanks.html (decodes “+” as a space)**

```
const p = new URLSearchParams(location.search);
document.getElementById('out').textContent = [...p].map(([k, v]) => k + ': ' + v).join(' | ');
```


## Troubleshooting guide
| Symptom | Likely cause | Fix (Rocky 10 / Kubuntu 26.04) |
| --- | --- | --- |
| `npx: command not found` | Node not on PATH (nvm not loaded) | `source ~/.bashrc` then `node -v`; both systems use nvm from Lab 0 |
| Validator reports `void-style` or `attribute-boolean-style` | Style rules in the recommended set | Run `npx prettier --write "*.html"` or use `required` without a value |
| Page not found at `/week02/` | File saved elsewhere | Confirm path `/var/www/webeng/week02/register.html`; Rocky: `restorecon -Rv` after moving files |
| Name shows `Ali+Raza` on thanks page | `decodeURIComponent` does not turn “+” into space | Use `URLSearchParams` as shown above |

## Viva prompts and marking notes
- Ask which controls would break for a screen-reader user if `label` were removed.
- Ask why the form uses GET in the lab and what would change with POST (data in the body, no query string, server needed).
- Marking points: valid and formatted HTML (3), correct input types / attributes (3), accessibility evidence (2), toolchain (1), viva (1).

## Answers to review questions
1. `<main>` is a landmark that assistive technology can jump to and that tells search engines where the primary content is; a `div` carries no meaning. Only one `main` per page.
2. GET for safe, repeatable, bookmarkable requests such as a search; POST for state changes or sensitive data such as registration or login.
3. `03[0-9]{2}-[0-9]{7}`: literal “03”, two digits (operator code), a hyphen, then seven digits.
4. Browser checks can be disabled or bypassed with curl or DevTools; the server is the trust boundary and must validate every request.
5. Any four of: labels bound to inputs, skip link, landmarks, logical keyboard order, visible focus, `lang` attribute, `autocomplete` tokens, sufficient contrast, native controls.
