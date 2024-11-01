#!/bin/bash

# Set the database details
DB_CONTAINER_NAME="mysql-manufacture-inventory"
DB_USERNAME="sail"
DB_PASSWORD="password"
DB_NAME="manufacture_inventory"
DUMP_FILE="database_manufacture.sql"

# Step 1: Grant permissions to user 'sail' (optional step if permissions are an issue)
docker exec -i $DB_CONTAINER_NAME mysql -u root -p"$DB_PASSWORD" -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USERNAME'@'%' IDENTIFIED BY '$DB_PASSWORD'; FLUSH PRIVILEGES;"

# Step 2: Dump the database
docker exec -i $DB_CONTAINER_NAME mysqldump -u $DB_USERNAME -p"$DB_PASSWORD" $DB_NAME > $DUMP_FILE

# Check if the dump was successful
if [ $? -eq 0 ]; then
    echo "Database dump successful. File saved as $DUMP_FILE"
else
    echo "Database dump failed. Please check credentials and try again."
fi
