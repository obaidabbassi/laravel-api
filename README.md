# Student Management REST API

## Overview

This is a RESTful API built with Laravel that provides resources for managing student data. It includes endpoints for:

Creating new student records
Retrieving individual student records
Retrieving a list of all students
Updating existing student records
Deleting student records
Handling user login and logout

## Installation

Clone the repository:

Bash
git clone https://github.com/obaidabbassi/laravel-api.git

## Usage

Available Endpoints:

Endpoint	      Method	        Description
/api/add   POST	       Create a new student record
/api/all	    GET	         Retrieve a list of all students
/api/{id}    GET	        Retrieve a specific student record
/api/{id}    PUT/PATCH	   Update a student record
/api/{id}	     DELETE	     Delete a student record
/api/login	      POST 	             Login a user
/api/logout	      POST	             Logout a user




