### Load data from Google Sheets (including multiple worksheets) and display on page

## What's the point of this?
**Allows clients to update a small piece of content where otherwise a CMS would be overkill. For example, a food menu.**
**Provides a simple way of updating a website in a format that most businesses understand.**

**No need for any login/admin function as this is taken care of by Google.**

![Screen grab of formatted data in browser](https://github.com/pualv/sheetsmenu/blob/master/menu%20screen%20grab.png)  

*Screen grab of formatted data in browser*

The formatting is fixed for a food menu so will only handle four columns (but any number of rows) from the spreadsheet.

Here’s the [spreadsheet](https://docs.google.com/spreadsheets/d/1dBnukgGOpHtTcjqZJ_cfLKQj8n5recdOUn4MYuoypVE/edit?usp=sharing) in Google Sheets. 


It will fetch multiple worksheets from each ‘sheet’. Each will be displayed under a header which is the name that you give to the worksheet. So you could have a separate worksheet for starters, mains etc. Or a separate worksheet for different menus e.g. lunch, dinner. 


#### You will need:

 * A Google account.

 * A document in Google Sheets with four columns.

 * A sheet ID string.

 * An API key. 


How you get the sheet ID and API key is described below. (Getting the sheet ID is easy. Getting the API key is straightforward but a bit of a journey. In short, you have to enable a ‘project’ in the Google developers API and get ‘credentials’.)

I may get round to putting the CSS I used at some point (I used flexbox).

(Note: empty fields at the end of rows or foot of columns will be missed out. This is why I have put the non-optional cost in the final column.)


### Get Sheet ID

Open your sheet in Google Sheets.

Click on ‘Share’ button top right.

Click ‘Get shareable link’

Click ‘Copy link’

You’ll get something like this:

https://docs.google.com/spreadsheets/d/1dBnukgGOpHtTcjqZJ_cfLKQj8n5recdOUn4MYuoypVE/edit?usp=sharing

Select ‘Anyone with the link can view’

Copy the long complicated string out of your link. This is your Sheet ID. 

Paste it into $sheet_id =‘’ at the top of the PHP.


### Get API Key

Google don't make it easy. Hang on in there for some clicking. You're mostly looking for blue boxes or links.

Go to the Google Developers API Dashboard. This should be [here](https://console.developers.google.com/project/_/apiui/apis/library):

At the top of the page select ‘Create project’. 

Click on ‘+’ button at top right of the pop window.

Name your project.

Click ‘Create’.

Your project name should be in same place as ‘Create project’ button was at top of page.

Select your project.

Click on the ‘+ Enable APIs and services’ link at top of page.

A big menu will appear. Look for Sheets API under ‘G Suite APIs’ (which has the Google red Gmail envelope icon next to it).

Click ‘Enable’ at top of page.

Click blue ‘Create credentials’ button, top right.

You'll see this text:
Find out what kind of credentials you need
We'll help you set up the correct credentials. 
If you want you can skip this step and create an API key, client ID or service account.


Click the link on 'API Key'.

Give it a name, if you want.

Leave ‘Key Restriction’ at ‘None’ unless you know which web address or IP address you'll be using (for CRON jobs) in which case you can select ‘HTTP referrers’ or ‘IP addresses’ – another box will appear asking you to enter the require URL or IP address. You can change this later.

Click ‘Create’.

A window pops up with your key. Copy it, job done (phew).
