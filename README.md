## Installation
1. Clone `https://github.com/KellsCooKiES/event-participants-API.git`
2. install composer dependencies
3. set up datatbase
4. run

     -`php artisan migrate`
     
     -`php artisan passport:install`
     
     -`php artisan db:seed` - create 4 events.



## Usage
List of supported methods:
   1. Login: method:POST, URL: `http://host/oauth/token`
    
   2. Register: method:POST, URL: `http://'host'/api/register`
     
   3. List: method:GET, URL: -`http://'host'/api/participants`
                             -`http://'host'/api/participants?event={id}` -filtered list
    
   4. Create: method:POST, URL: `http://'host'/api/event/{event_id}/participants`
    
   5. Show: method:GET, URL: `http://'host'/api/participants/{id}`
 
   6. Update: method:PUT, URL: `http://'host'/api/participants/{id}`
     
   7. Delete: method:DELETE, URL: `http://'host'/api/participants/{id}`




