# A Better Community Database

*A Better Community Database for non-profit organizations. *

ABCD revolutionizes data management for non-profits with an easy-to-use, flexible approach to collaborative learning. And with its powerful survey creation and ad-hoc report generation features, our software for non-profits will help you create significant insights quickly. ABCD is a smart choice for any NPO or social good collaborative looking for a better way to do data.

This repository is dedicated to the development of ABCD v3 which is based off of [Laravel](https://laravel.com/) and [Vue.js](https://vuejs.org/).


If you would love to try ABCD, checkout the live version at [betterdatabase.ca](https://betterdatabase.ca).

## Configuration

After cloning this repository, follow the steps below. If you're using the command line, make sure that you `cd` into the cloned version of this repository. 

### 1. Create .env file

 `$ mv .env.example .env` or simply rename **.env.example** to **.env**.

### 2. Generate Application Key

Run `$ php artisan key:generate` in your command line. 

This should automatically set a value for the `APP_KEY` environment variable in the .env file that you created in **Step 1**.

### 3. Configure database

Still in the **.env file**, set the following variables according to your local environment:

```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Here's an example:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=abcd
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Install dependencies
In your command line, assuming that you're the cloned repository's directory, run:

`npm install && composer install`

And that's about it!

## Features

### Records
Users can create, read, update, and delete records in ABCD. But before that, record identities must be configured, and record types must be created, respectively.

#### Record Identity
A record identity defines a record’s fields, and it gives ABCD an idea as to how the record should be treated. This means that all record types of the same identity will have the same fields.

A record type must have one of the four identities which are staff, volunteer, client, and external. 

Staff records are ideally for records of people hired and paid to work or simply the employees in an organization. What makes staff records unique is that these can be given caseloads which are simply other records that are ‘caseload-able’.

Volunteer records, ideally, should be used for records where tracking volunteer hours is imminent. Volunteer records are also caseload-able which means that these can be assigned to staff records.

Client records are for an organization’s participants, clients, or people who directly benefit from an organization’s program/s. Client records, like volunteer records, are also caseload-able.

Lastly, the external records are for records of entities that are not part of the organization like funders or donors, and external auditors.

To configure a record identity, a combination of three fields that amount to a value of 5 must be assigned to the identity.

#### Fields
There are 6 record fields. Each one has a corresponding value and all are required to be filled in when creating a record.

1. First Name - primary - 2
2. Last Name - primary - 2
3. Business Name - primary - 3
4. Email Address - secondary - 1
5. Contact Number - secondary - 1
6. Birth Date - secondary - 1

#### Record Types
ABCD enables organizations to create their own record types. A record type basically requires a name, and should be given an identity.

#### Record Deduping
One of the important functions of Identities is deduping. ABCD automatically treats records that belong to the same identity and have completely identical field values as one. 

### Access Control (Roles, Scopes, Permissions)

#### Roles
A role has three components: its **scope**, its **permissions**, and the user that it is associated with. A user has a scope and have permissions through its role.

A role can be assigned to any amount of users, and users can have any amount of roles. For example, a user can be assigned a *Team Manager role* and a *Program Manager role*.

#### Scopes
A scope simply determines the resources that a user has access to (can see).

There are four scopes: 
* Self 
* Case Load
* Program 
* Team, and; 
* Universal 
    
These scopes grant varying levels of access to a user.

First and foremost, the **self scope** grants the lowest level of access making it the most restrictive scope. Users with a self scope only have access to their own user profiles.

The **case load scope** additionally grants users access to all of the records which are directly associated/assigned to a user.

The **program scope** additionally grants users access to all of the resources of the programs which the they are is directly assigned to.

The **team scope** additionally grants users access to all of the resources of the teams where the users belong to.

Lastly, the **universal scope** grants users access to all of the resources in the database.

In cases when a user has multiple roles, the user will attain the highest level scope among its roles. For instance, a user is assigned to a *Program Manager* role which has a program scope and a *Team Manager* role which has a team scope. Since the team scope has a higher level of access than the program scope, the user will have a team scope and is able to access resources inside the user’s team.

#### Permissions
Generally, permissions authorize users to perform an action on a resource. Since defining a user’s readable resources is already handled by scopes, permissions, for the most part, determine the resources/entities that a user can create, modify, and delete.

For example, an organization can create a *Role Administrator* who is only allowed to create, modify, and delete roles, or a *Program Manager* role who is only allowed to write to records and programs.

The permissions available in ABCD are:
1. Write records
2. Write programs
3. Write teams
4. Write roles
