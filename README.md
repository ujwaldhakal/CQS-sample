## CQS Sample

### Steps for typical request for actions( write ):

*Note: I am using Laravel's default router for routing. Also I have tried to make objects immutable as possible. There are no setters in any of these classes.*

1. Requests are sent to controllers( which can be called commands).
1. Controllers call a service(I think this should be named as command handler)
1. The service either succeeds or throws an exception.
1. If it succeeds, it triggers an event which have listeners that are triggered
1. If it fails, an error message is sent back

### Few Features

### Steps for typical request for actions( read ):
1. Controller basically calls a query.

### Few Notable Features

1. Controller is a class with a single method `__invoke`.
1. There are no Controller suffix in the controller name. One example is `Announce`. It has a single method `__invoke` and that is it.
1. We use `uuid`s so no database generated primary ids. No need to wait for database to generate a key to respond.
1. There are always events triggered for an action.
1. Queries are handled differently than and have no relation to entities per se. They are basically database queries.
1. Transformers are added for queries because there might be a change to what column maps to which field in the database.

### Folder Structure

* `/src` is where application logic is
* folders inside `/src` are divided into modules(domains) and they have their own properties
* A domain can have
  + Handlers
  + Services
  + Events
  + Listeners
  + Queries
    + Filters
    + Alias
  + Fields  
  + Entities
  + Queues
  

#### 1) Handlers -: 
Handlers are generally the domain configuration handler which handles event listener / entities mapping i.e it states that  whenever a user is registered a `userRegisterend` event is triggered with respect to that event `PersistUserDetails`, `SendConfirmationEmail` listeners are attached for e.g
 ``` 
 UserRegistered::class => [
                PersistRegistration::class,
                PersistUserToken::class,
                PersistDefaultEmployeeMetaFields::class,
                SendRegistrationConfirmationEmail::class
            ], 
```
The other thing that it does currently is resolving classes like 
````
$this->app->bind(AnnouncementInterface::class, function ($app, $params = []) {
            return new Announcement(app(\Illuminate\Database\Connection::class));
        });
````
whenever someone uses announcementInterface in an application a concrete announcement class is returned with desired connection.


#### 2) Services -: 
Services are the backbone of write part. Every write has its own service like `CommentCreationService`, `CommentDeletionService`,`CommentUpdateService` etc.
Whenever the data are passed from controller / commands to this service it validates the data first, whether the data are further processable or not. If data are processable it filters and generates data ready for persist. 
If data are not processable an exception is thrown before the service starts processing further. One interesting thing about service is it generate all persistable data (rows) to be persist in database along with primary key so we dont have depend upon database to track down the things, 
another thing is we can write on disk later and respond immediately but this has its own risk which we can discuss later.


#### 3) Events -: 
Events are the bridge for between listener and services. Events helps us to pass services to listeners and track down the actions in an application like `UserRegistered` ,`CommentCreated`.

#### 4) Listeners -:
Listeners are the list of consequences of an event or in another word we can say impact of an event. Like in our application we can say whenever a `user` gets registered we will save data 
in database, send verification emails. There can be multiple listeners of an event.

#### 5) Queries -:
Queries are the backbone of read part. Every read has its own query file like `FetchUsers`,`FetchNotifications` etc. Queries fetch data from database / join tables / make data/ filter fields
do some magics and return the actual desired data. There are two key players for query to assist for fetching / making data and they are -: 

+ Filters -:  Filters accepts the query parameters in an url like `fields=id,name,email&type=verified&year=2019` they are responsible for 
filtering out the request for query and keep the processable data like what kind of fields are applicable to be returned on response 
how the data should be filter i.e by year / month / type etc  
````
private $allowedFilters = [
        'fields',
        'type',
        'year'
    ];
    private $allowedFields = [
        'id',
        'name',
        'email'
    ];
````

+ Alias -: Sometimes when we join multiple tables we may face problem like conflict between the column of table so with alias it will generate the fields mapped with 
 column name with this approach we can easily use mysql functions in our query for e.g 
````
       'applicant_id' => USERS_TABLE . '.id',
        'applicant_name' => "CONCAT(" . USERS_TABLE . ".first_name,' '," . USERS_TABLE . ".last_name)",
        'timeoff_id' => TIME_OFF_TABLE . '.id',
        'timeoff_status' => TIME_OFF_TABLE . '.status',
        'timeoff_days' => "datediff(" . TIME_OFF_TABLE . ".end," . TIME_OFF_TABLE . ".start)",
````

 
#### 6) Fields -: 
Fields are just reusable static database column names of table mapped in constant.
````
const COMPANY_FIELDS = [
        'name',
        'email',
    ];

    const COMPANY_INFO_FIELDS = [
        'tax_number',
        'business_legal_name',
    ];
````


#### 7) Entities -:
Entities are generally the domains of our application in other typical term we can say it was model. Entities generally persist 
the data to database / remove the data from the database provided by services. Only entities knows where to persist the given data.
It does not perform any validation works we assume the data reached here are totally safe and clean data.
 

#### 8) Queues -:
All the background tasks are handled by this like whenever a many rows has to be updated or write data to more than one database or generate 
report from database in that case we use this.
