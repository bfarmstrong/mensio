# MeasureMyClinic

## Requirements

The only software required to be installed on your local machine is Docker with the `docker-compose` command line tool.

## Getting Started

For development purposes, the following steps will get the system setup on your machine:

```bash
# Setup the Docker environment
git submodule init
git submodule update
cd laradock
cp env-example .env
docker-compose up -d nginx mysql
docker-compose exec workspace bash

# Setup the project inside of the container
composer install
cp .env.example .env
php artisan key:generate
php artisan db:seed --class="DefaultRolesSeeder"
php artisan db:seed --class="AdminSeeder"
php artisan db:seed --class="DefaultClinicSeeder"
php artisan import:default-questionnaires
exit

# Fix permissions outside of the container
cd ..
sudo chmod -R 777 storage bootstrap/cache
```

After doing all of this, you should be able to access your localhost URL, `http://localhost` or the default Mindspace clinic, `http://mindspace.localhost`.  You should be able to sign into both websites with the default administrator credentials, `admin@example.com:secret`.

## Deployment

The only action required to deploy to the production environment is to ensure that a Docker image is built for the most up-to-date code.  To generate this preview you must run the following code.  Ensure that you have Ansible installed on your machine.

```bash
# Install Ansible if it isn't installed already
brew install ansible

# Run the "playbook" to generate the Docker image
ansible-playbook playbooks/deploy_docker_image.yml
```

You **must** be authenticated with the production AWS on your machine.  If you aren't then the upload step will fail.  Once the image has been uploaded you then can go to ECS and update the existing task in the cluster to use the newest image tag.  The cluster should replace the instances automatically.

There is a second task in ECS for migrating the database.  If you want to migrate the production database then simply run the migrate task in ECS and it will run the latest migrations from the newest image tag.

## Extras

### Importing Legacy Users

To import users from the legacy system, run the included Artisan command.  This command must be run inside of the Docker container.

```bash
php artisan import:legacy-users
```

To import the users into a specific clinic, provide the UUID of the clinic as an option.

```bash
php artisan import:legacy-users --clinic="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
```

When not running in production `APP_ENV=production`, the data that is loaded from the legacy users server will be anonymized with random values.

### Importing Legacy Questionnaires

To import questionnaire responses from the legacy system, run the included Artisan command.  This command must be run inside of the Docker container.

```bash
php artisan import:sheet-data assess
php artisan import:sheet-data --language="fr" assess
php artisan import:sheet-data mbct
php artisan import:sheet-data --language="fr" mbct
php artisan import:sheet-data mbsr
php artisan import:sheet-data --language="fr" mbsr
```

You may also provide a clinic that the responses would be created for.  Typically you want the response to be created for the same clinic as the legacy users.

```bash
php artisan import:sheet-data --clinic="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" assess
```

### Importing Questionnaires

New questionnaires may be created at any time by using the editor [here](https://surveyjs.io/Survey/Builder/).  The system can parse JSON files from the builder and transform them into questionnaires that may be used in the system.  This command must be run inside of the Docker container.

```bash
php artisan import:questionnaire "$(cat /path/to/survey.json)"
```

You may provide a name and scoring mechanism for the questionnaires in this command as well.  By default the questionnaire is named after the name of the first page of the survey.

```bash
php artisan import:questionnaire \
    --name="survey" \
    --scoring-method="sum" \
    "$(cat /path/to/survey.json)"
```

You may also provide a score for individual answers.  Doing so will require you to manually edit the survey JSON file.  An example can be seen below.  A "scores" key is added to each individual question that faciliates scoring.  This key is not standard for the survey builder and has to be added manually.

```json
{
    "pages": [
        {
            "elements": [
                {
                    "type": "matrix",
                    "columns": [
                        "Column 1",
                        "Column 2",
                        "Column 3"
                    ],
                    "name": "survey>>>main",
                    "rows": [
                        "Row 1",
                        "Row 2"
                    ],
                    "scores": [
                        0,
                        1,
                        2
                    ],
                    "title": "Title"
                }
            ]
        }
    ]
}
```
