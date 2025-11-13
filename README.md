# import_time_spent_from_jira

## Installation
composer install
php artisan migrate
npm install

To properly Login via JIRA OAuth in your local development:
-Use the `.env copy` instead of the default `.env`
-Download/Install ngrok from here: https://ngrok.com/download/windows
-After downloading/installing, run this command on the terminal from the ngrok directory:
    .\ngrok.exe http --host-header=rewrite <<your-local-project-url>>:80
-Copy the generated link to the `APP_URL` of your .env file. make sure to also edit the URL on the `ATLASSIAN_REDIRECT_URI` in the same .env file.
-Make sure you have a JIRA account (doesn't matter if free or not).
-Once your done signing up, paste your JIRA URL in the .env file
    JIRA_BASE_URL="https://<<your-jira>>.atlassian.net"
    JIRA_EMAIL="<<your-jira-email>>"
-Go to JIRA Developer Console (https://developer.atlassian.com/console) and create an OAuth 2.0 Integration
-Give your project a name then go to the Settings of that OAuth 2.0 App. Copy and paste the `Client ID` and `Secret` to the your .env file.
-Go to the Authorization menu and click on the Configure button of the OAuth 2.0 (3L0) then paste the value of the `ATLASSIAN_REDIRECT_URI` from your .env file
-Go to the Permissions menu and configure these 2 APIs: User Identity API and Personal data reporting API
-From the User Identity API, enable 'read:me'
-From Personal data reporting API, enable 'report:personal-data'
-Next generate your own API tokens from here: https://id.atlassian.com/manage-profile/security/api-tokens
    Just click on the Create API token and set the expiry date. Then copy and paste the generated token to the `JIRA_API_TOKEN` on your .env file

JIRA Projects that are enabled to read/write/update/delete from the JIRA API has some specific requirements
-Project template should be a 'Scrum' type
-Project type should be 'Company-managed'
If you created a project that are not in these 2 conditions, you might not be able to pick up the issues/tasks on that project.

## Additional Note
I cannot get to work the live reload function with vite while on ngrok proxy so run `npm run build` instead whenever you made changes on the Vue JS side.
