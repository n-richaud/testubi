```bash
make dev
```

L'application est accessible à [http://localhost:8088/](http://localhost:8088/).

La BDD est accessible sur localhost sur le port 3366.

dans le dossier dev se trouve un export des requetes jouables par postman ou insomnia 



## Doc API 


### Routes

#### Ajout étudiant :

/student/add

Method : POST

{

lastname: toto

firstname: dupont

birthday: 1993-09-02 (date au format 8601)

}
#### Maj étudiant
/student/{id}

Method : PUT

{

lastname: toto

firstname: dupont

birthday: 1993-09-02

}
#### suppresion étudiant
/student/{id}

Method : DELETE

#### Ajout notes
/student/{id}/grades/add

Method : POST

{

subject: maths

grade: 12

}
### Moyenne d'un étudiant
/student/{id}/grades/average

Method : GET

#### Moyenne générale 
/grades/average

Method : GET
