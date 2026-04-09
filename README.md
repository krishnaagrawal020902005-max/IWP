<img width="1306" height="857" alt="Screenshot 2026-04-09 115840" src="https://github.com/user-attachments/assets/e6d24d8c-9e96-4fe4-8bca-26191e4684a3" /># 🌐 Internet Web Programming — Lab Practicals

![HTML](https://img.shields.io/badge/HTML-5-orange?style=flat-square)
![CSS](https://img.shields.io/badge/CSS-3-blue?style=flat-square)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-Backend-purple?style=flat-square)
![MySQL](https://img.shields.io/badge/MySQL-Database-blue?style=flat-square)
![XML](https://img.shields.io/badge/XML-XSD-green?style=flat-square)
![Perl](https://img.shields.io/badge/Perl-Scripting-lightgrey?style=flat-square)
![Status](https://img.shields.io/badge/Status-Completed-brightgreen?style=flat-square)

A complete collection of **11 Web Technology Practicals** covering frontend design, backend logic, database integration, XML validation, and scripting.

---

## 📑 Table of Contents

* [Overview](#-overview)
* [Tech Stack](#-tech-stack)
* [Practicals List](#-practicals-list)
* [Screenshots](#-screenshots)
* [Setup & Execution](#-setup--execution)
* [Key Features](#-key-features)
* [Project Structure](#-project-structure)
* [Author](#-author)

---

## 📖 Overview

This repository contains hands-on lab practicals built as part of the Internet Web Programming course. Each practical demonstrates a specific concept — from basic HTML layout to PHP session management, MySQL integration, XML schema validation, and Perl scripting.

Each practical is:

* ✅ Fully self-contained
* ✅ Built with original UI/UX designs
* ✅ Beginner to intermediate level

---

## 🛠 Tech Stack

| Layer | Technologies |
|-------|-------------|
| **Frontend** | HTML5, CSS3, JavaScript (ES6) |
| **Backend** | PHP 8+ |
| **Database** | MySQL |
| **Markup & Validation** | XML, XSD Schema |
| **Scripting** | Perl |

---

## 📋 Practicals List

| # | Practical | Concept | Tech Used |
|---|-----------|---------|-----------|
| 1 | Train Booking Page | Basic HTML layout & navigation | HTML, CSS |
| 2 | Alphabet Explorer App | JS interaction & string operations | HTML, CSS, JS |
| 3 | Periodic Table | Styled UI with filters & modal | HTML, CSS, JS |
| 4 | ISBN Validator | Regex-based validation | HTML, CSS, JS |
| 5 | Tic Tac Toe | Game logic with AI mode | HTML, CSS, JS |
| 6 | Matrix Operations | Array operations & transpose | HTML, CSS, JS |
| 7 | Hospital Registration Form | Form validation with steps | HTML, CSS, JS |
| 8 | Shopping Cart | PHP Sessions & cart logic | PHP, HTML, CSS |
| 9 | Quiz App | PHP + MySQL database | PHP, MySQL |
| 10 | XML Student Registry | XML + XSD schema validation | XML, XSD, JS |
| 11 | Perl Arrays | Perl array scripting | Perl |

---

## 📸 Screenshots

### Practical 1 — Train Booking Page
> Basic HTML layout with a dark industrial theme, search form, results table, and booking buttons.

<img width="1306" height="857" alt="Screenshot 2026-04-09 115840" src="https://github.com/user-attachments/assets/3ef298b4-32b8-4f53-919c-566672fca0a1" />

---

### Practical 2 — Alphabet Explorer App
> Terminal-style interface with an interactive alphabet matrix, string operations, and ASCII character info.

<img width="1320" height="798" alt="Screenshot 2026-04-09 120011" src="https://github.com/user-attachments/assets/af0fee11-e4cf-495a-888a-4d1fa0606692" />

---

### Practical 3 — Periodic Table
> Color-coded periodic table with category filters, search, and a click-to-expand element detail modal.

<img width="1313" height="604" alt="Screenshot 2026-04-09 120038" src="https://github.com/user-attachments/assets/a656ce8e-4ce9-4085-851a-19cb6f8188bf" />

---

### Practical 4 — ISBN Validator
> Dark warm-toned tool that validates ISBN-10 and ISBN-13 numbers using regex and check digit algorithms. Includes batch mode.

<img width="1303" height="721" alt="Screenshot 2026-04-09 120225" src="https://github.com/user-attachments/assets/e0192a4f-9e3d-4c9a-8c4a-48c4ef6f920a" />

---

### Practical 5 — Tic Tac Toe
> Space-themed Tic Tac Toe with animated stars, scoreboard, 2-player mode, and a built-in AI opponent.

<img width="1320" height="841" alt="Screenshot 2026-04-09 120248" src="https://github.com/user-attachments/assets/a89aae65-c70a-4099-b671-c583b4170282" />

---

### Practical 6 — Matrix Operations (Input & Transpose)
> IBM-style engineering tool with configurable matrix dimensions and operations like Transpose, Determinant, Row/Column Sums.

<img width="1300" height="807" alt="Screenshot 2026-04-09 120333" src="https://github.com/user-attachments/assets/937e8bb8-30bb-4ca6-be11-7ef988cc9e8e" />

<img width="1297" height="792" alt="Screenshot 2026-04-09 120350" src="https://github.com/user-attachments/assets/96b03b88-975d-4bb5-9466-c4b3db28ff46" />

---

### Practical 7 — Hospital Registration Form
> Multi-section patient registration form with a 4-step progress bar, real-time JS validation, and a success screen.

<img width="1308" height="850" alt="Screenshot 2026-04-09 120420" src="https://github.com/user-attachments/assets/1462ded0-6a5f-4cf5-8042-aaaba6214f87" />

---

### Practical 10 — XML Student Registry
> Dark navy dashboard that parses student XML data, displays records with filters, CGPA badges, and a live XML node viewer.

<img width="1306" height="829" alt="Screenshot 2026-04-09 120452" src="https://github.com/user-attachments/assets/7b07f4df-ad96-4ad1-bd14-05ac19b35616" />

---

## ⚙️ Setup & Execution

### HTML / CSS / JavaScript (Practical 1–7, 10)

Simply open the file in any browser:
```bash
# Double-click the .html file, or
open practical1_train_booking.html
```

---

### 🛒 PHP Shopping Cart (Practical 8)

Start PHP's built-in server:
```bash
php -S localhost:8000 practical8_shopping_cart.php
```
Then open: `http://localhost:8000`

---

### 🧠 PHP + MySQL Quiz App (Practical 9)

1. Open **phpMyAdmin**
2. Create database `quizdb`
3. Copy the SQL from the top of `practical9_quiz_app.php`
4. Execute the queries to create the `questions` table and insert data
5. Run the server:
```bash
php -S localhost:8000
```
Then open: `http://localhost:8000/practical9_quiz_app.php`

---

### 📄 XML + XSD (Practical 10)

Make sure all three files are in the same folder:
- `students.xml`
- `students.xsd`
- `practical10_xml_students.html`

Then open the HTML file in a browser.

---

### 🐪 Perl Script (Practical 11)

```bash
perl practical11_perl_arrays.pl
```

---

## ✨ Key Features

* ✔️ Responsive layouts using CSS Grid and Flexbox
* ✔️ Real-time JavaScript form validation
* ✔️ Game logic with AI opponent (Tic Tac Toe)
* ✔️ Regex-based ISBN-10 and ISBN-13 validation
* ✔️ PHP session handling for cart persistence
* ✔️ MySQL database connectivity for dynamic quiz
* ✔️ XML schema (XSD) validation with live data viewer
* ✔️ 10 Perl array operations with formatted terminal output

---

## 🗂 Project Structure

```
.
├── index.html                        ← Master navigation page
├── practical1_train_booking.html
├── practical2_alphabet_app.html
├── practical3_periodic_table.html
├── practical4_isbn_validator.html
├── practical5_tictactoe.html
├── practical6_matrix_operations.html
├── practical7_hospital_form.html
├── practical8_shopping_cart.php
├── practical9_quiz_app.php
├── practical10_xml_students.html
├── students.xml
├── students.xsd
├── practical11_perl_arrays.pl
└── screenshots/
    ├── p1_train_booking.png
    ├── p2_alphabet_app.png
    ├── p3_periodic_table.png
    ├── p4_isbn_validator.png
    ├── p5_tictactoe.png
    ├── p6_matrix_ops.png
    ├── p6_matrix_transpose.png
    ├── p7_hospital_form.png
    └── p10_xml_students.png
```

---

## 👤 Author

(https://github.com/krishnaagrawal020902005-max)
---

## ⭐ Show Your Support

If this helped you, feel free to star the repository and share it with your classmates!
