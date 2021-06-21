# BF Seguros

A insurence company called BF Seguros had asked you to make a managament system for them.

The **system must be done in a PHP API** which will get the data from the database which must be done in MySQL.

The **front-end must be done with the Materialize framework and JavaScript** that will mediate the communication between the user and the back-end.

## System screens

- Login screen.
- Dashboard.
- View/register/update/delete customer.
- View/register/update/delete manager.
- View/register/update/delete contract.

## Database tables

- manager
  - name
  - role
  - email
  - password
  - last_acess
  - reg_date
- customer
  - name
  - type // person or company
  - status // engaged, not engaged, 
  - since
- contract
  - customer
  - type // auto, hull, health, rural
  - status // canceled, active
  - value
  - start
  - end
