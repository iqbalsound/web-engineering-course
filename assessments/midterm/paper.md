| **Marks** | 20 = Objective 10 (CLO_1) + Subjective/Practical 10 (CLO_2) | **Time** | 30 min + 90 min |
| --- | --- | --- | --- |
| **Allowed** | Objective: nothing. Practical: MDN / PHP docs offline copies only | **Environment** | `/var/www/webeng/mid/<rollno>/` |

# Section A – Objective (10 × 1 mark, CLO_1)

**Q1.** Which protocol encrypts HTTP traffic? **[1]**

- A. FTP
- B. TLS
- C. SMTP
- D. ARP

**Q2.** DNS translates… **[1]**

- A. IP addresses to MAC addresses
- B. host names to IP addresses
- C. HTML to CSS
- D. URLs to files

**Q3.** Which status class indicates a client error? **[1]**

- A. 2xx
- B. 3xx
- C. 4xx
- D. 5xx

**Q4.** In a three-tier architecture the data tier holds… **[1]**

- A. the browser
- B. the database
- C. the CSS files only
- D. the router

**Q5.** Which element groups the main navigation links? **[1]**

- A. `nav`
- B. `aside`
- C. `footer`
- D. `figure`

**Q6.** What does `<input type="email" required>` provide? **[1]**

- A. Encryption
- B. Native format and presence validation
- C. Server-side validation
- D. Auto-complete from the server

**Q7.** Which of these is a URN? **[1]**

- A. `https://example.pk/a`
- B. `urn:isbn:9780133775983`
- C. `ftp://host/file`
- D. `mailto:x@y.pk` as a path

**Q8.** Which item is NOT part of a URL? **[1]**

- A. scheme
- B. host
- C. HTTP status code
- D. path

**Q9.** In MVC the controller… **[1]**

- A. stores data only
- B. handles input, calls the model and selects the view
- C. renders pixels
- D. is the database

**Q10.** HTTP/3 runs over… **[1]**

- A. TCP
- B. QUIC (UDP)
- C. FTP
- D. ICMP

# Section B – Practical (10 marks, CLO_2)

Create a one-page site **“Campus Event Board”** in `/var/www/webeng/mid/<rollno>/` with `index.html`, `style.css` and `app.js`:

| Part | Requirement | Marks |
| --- | --- | --- |
| (a) | Semantic `header`, `nav`, `main` and `footer`; exactly one `h1` | 2 |
| (b) | A form containing a text/search input with `required` and a number input “max fee”, each with a `label` | 1 |
| (c) | At least six event cards in a CSS Grid that becomes one column below 600 px; hover effect on cards | 3 |
| (d) | JavaScript that filters cards by title as the user types and by max fee, and shows “N event(s) shown”; use `textContent`, never `innerHTML` | 3 |
| (e) | `html-validate` reports no errors and the browser console shows no errors | 1 |

Submit by committing the folder to Git and saving the output of `./check.sh <rollno>` as `report.txt`.
