# A faire
### MimeType
[] - Rendre le champs code UNIQUE

### ReportFileType
[] - Rendre le champs extension UNIQUE\
[] - Paramétrer la validation de suppression des ReportFileType référencés \
        -> rajouter un paramètre dans settings pour gérer ce cas de figure \
[] - Valider la suppression de ReportFileType en fonction du paramètre y rattaché \

### ReportFile
[x] - Ajouter l'entrée retrieve_by_wildcard_label dans les Settings\
[x] - Ajouter l'entrée retrieve_by_name_label dans les Settings

### Report
[] - FormatRule pour les Headers

### Tests à effectuer (rajouter 'test_' devant les fonctions)
[] - AuthenticationTest
[] - EmailVerificationTest
[] - PasswordConfirmationTest
[] - PasswordResetTest
[] - RegistrationTest

### Modèle
[] - Pour tous les modèles, tester qu'un utilisateur non authorisé ne peut CRÉER, MODIFIER, SUPPRIMER

### Champs uniques
[] - Tester les champs uniques

### @IP
[] - Valider une adresse IP (preg App\Providers\AppServiceProvider)

### OsServer
[] - Add code field

### Report Treatment
[] - Gérer les étape de traitement (workflow) dans les Settings du Système.

### ReportFileAccess
[] - Rajouter attribut port

### AccessPorocole
[x] - Rajouter attribut default_port
[x] - Utiliser les extensions dans les interfaces

### Settings
[] - utiliser les classes abstraites (comme avec Permissions) pour renvoyer les clés de config


### Format Rule
[] - Remplacer when_rule_result_is par un ENUM RuleResultEnum => followed, broken

### selectedretrieveactions
[] -> implémenter le polymorphic relationships

### DynamicAttribute
[] -> add and manage fieldkey attribute

### Job Queues
[x] -> track blocked queues -> where "reserved_at" for limit time
[] -> track failed jobs

### Job Batches
[x] -> track and delete  -> where "pending_jobs=0" and "finished_at" for limit time

## User Interface
[] -> Champs du Rapport / Regles Formattage: Aller vers une page "Regles Formattage/uuid/details" quand on clique sur le titre de l'onglet

