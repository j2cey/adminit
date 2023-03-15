### A faire
## MimeType
[] - Rendre le champs code UNIQUE

## ReportFileType
[] - Rendre le champs extension UNIQUE\
[] - Paramétrer la validation de suppression des ReportFileType référencés \
        -> rajouter un paramètre dans settings pour gérer ce cas de figure \
[] - Valider la suppression de ReportFileType en fonction du paramètre y rattaché \

## ReportFile
[x] - Ajouter l'entrée retrieve_by_wildcard_label dans les Settings\
[x] - Ajouter l'entrée retrieve_by_name_label dans les Settings

## Tests à effectuer (rajouter 'test_' devant les fonctions)
[] - AuthenticationTest
[] - EmailVerificationTest
[] - PasswordConfirmationTest
[] - PasswordResetTest
[] - RegistrationTest

## Modèle
[] - Pour tous les modèles, tester qu'un utilisateur non authorisé ne peut CRÉER, MODIFIER, SUPPRIMER

## Champs uniques
[] - Tester les champs uniques
