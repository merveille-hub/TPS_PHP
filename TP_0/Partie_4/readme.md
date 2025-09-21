Pour pouvoir envoyer des emails via PHP, il y'a plusieurs méthodes et j'ai choisi celle ci : 
- Envoyer avec sendmail
- Telecharge sendmail sur le site glob : XAMP que j'utilise qui contient le serveur web, contient aussi sendmail
- configurer sendmail.ini : 
    - donner le nom du serveur smtp : dans mon cas, j'ai utilise pour google gmail : smtp_server=smtp.gmail.com
    - donner le port du serveur smtp : pour google gmail, c'est : smtp_port=587
    - pour google, compte tenu de la verification en deux étapes, on doit configurer aussi *le mot de passe des applications* :
        - auth_username=adresse@email.com : la même où se trouve le *from dans le code PHP*
        - auth_password=code_de_16_caracteres : le mot de passe généré par google dans la section : *Mots de passe des applications*

- configurer php.ini afin qu'il se connecte à sendmail.ini : 
    - decommenter le chemin smtp_path pour donner le chemin complet où se trouve le sendmail.exe : sendmail_path = "C:/chemin/vers/sendmail.exe"
    - redemarer le serveur PHP


- 📘 DNS RECORDS – Documentation
 
  🔹 @record A
    - Type : Address Record
    - Description : Associe un nom de domaine à une adresse IPv4.
    - Exemple : mon-site.com -> 203.0.113.15
    - Utilisation PHP : 
        - Permet d’héberger le site PHP et d’y accéder via un nom de domaine.
        - permet que https://mon-site.com pointe vers ton serveur web où ton code PHP est hébergé.

  🔹 @record MX
    - Type : Mail Exchanger
    - Description : Définit le(s) serveur(s) chargé(s) de recevoir les emails du domaine.
    - Exemple :
        mon-site.com   MX 10 mail.mon-site.com
        mail.mon-site.com A 203.0.113.20
    - Utilisation PHP : 
        - Nécessaire pour l’envoi/réception d’emails via mail(), PHPMailer, etc.
        - Utilisation (PHP) : indispensable pour envoyer/réceptionner des emails via mail(), PHPMailer ou autres bibliothèques SMTP.
    - Paramètre "Priorité" : plus le chiffre est petit, plus le serveur est prioritaire.
 
  🔹 @note
    - Enregistrement A = pour ton site web (HTTP/HTTPS).
    - Enregistrement MX = pour tes emails (SMTP/IMAP).
    - Un projet PHP typique utilise les deux : A pour l’accès au site, MX pour la messagerie.

    👉 Exemple d’utilisation PHP pour vérifier un domaine mail :

    $email = "contact@mon-site.com";
    $domain = substr(strrchr($email, "@"), 1);

    if (checkdnsrr($domain, "MX")) {
        echo "Le domaine a un serveur mail configuré (MX).";
    } else {
        echo "Aucun serveur mail trouvé pour ce domaine.";
    }