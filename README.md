# Issue Tracker API

This is a simple API for issue tracker app built using Lumen.

How to run
---
1. Make sure you've installed at least `PHP ^7.1.3` and `MySQL`, and then create a database (i.e. `issue`).
2. Run `install.sh` on your CLI.
3. Set your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` on generated `.env` file.
4. Run `start.sh` on your CLI, the database will be generated with tables and you can access the application on <http://127.0.0.1:8000>

API
---
### Login
---
#### POST
{host}/login

**params:**
- email
- password

### Register
---
#### POST
{host}/register

**params:**
- name
- email
- password
- password_confirmation

### Category
---
#### GET
{host}/category
#### GET
{host}/category/{id}
#### POST
{host}/category

**params:**
- name
- description

#### PUT
{host}/category/{id}

**params:**
- name
- description

#### DELETE
{host}/category/{id}

### Label
---
#### GET
{host}/label
#### GET
{host}/label/{id}
#### POST
{host}/label

**params:**
- name

#### PUT
{host}/label/{id}

**params:**
- name

#### DELETE
{host}/label/{id}

### Issue
---
#### GET
{host}/issue
#### GET
{host}/issue/{id}
#### POST
{host}/issue

**params:**
- category_id
- label_id
- user_id
- name
- description
- due_date

#### PUT
{host}/issue/{id}

**params:**
- category_id
- label_id
- user_id
- name
- description
- due_date

#### DELETE
{host}/issue/{id}
