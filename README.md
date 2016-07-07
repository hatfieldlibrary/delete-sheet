# Delete-Sheet

## General Overview

This script reads through an excel file of Alma users with a primary ID in the first column.

Columns: Primary Identifier	/ First Name / Last Name / User Group / Expiry Date

it loads the users into an object, then works its way through the oject trying to delete the user. If for any reason the user can not be deleted the reason why will be included in the response.

## Requirements

You will need to get a USER API key for your institution in the Developer Network.

You will also need PHP Excel.
