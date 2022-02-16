# LoL

### Installation

You need to create a `env.json` file in the `secure` folder. (you can copy/paste `env-sample.json` as an exemple, every variable it contains is **mandatory**)

```json
    "db" : {
        "type": "mysql",        //Database Type
        "host": "localhost",    //Database Host
        "name": "dbname",       //Database Name
        "user": "user",         //Database User
        "password": "password"  //Database Password
    },
    "lang" : "en_EN",       //The language displayed*
    "test" : "false",       //Enable test mode**
    "env" : "dev"           //Environnement (dev / prod)***

    //* List of all languages in secure/languages.json

    //** Test mode will break iterations earlier on api and database to shorten loading times.

    //*** Dev mode displays all errors while prod doesn't.
```

### Tips

To force data update on API, just delete the `secure/version.json` file.