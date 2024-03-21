<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $details['subject'] }}</title>
</head>
<body>


    <div style="background-color: #FAFAFA; width: 100%; font-family: 'Arial', 'Helvetica Neue', 'Helvetica', sans-serif; box-sizing: border-box; padding-bottom: 25px; margin: 0;">
        <div style="background-color: #fff; color: #000; font-size: 1em; border-top: 2px solid #1100ff; border-bottom: 1px solid #E6E6E6; box-sizing: border-box; padding: 25px; width: 100%; max-width: 600px; margin-left: auto; margin-right: auto;">

        <p style="margin-bottom: 25px; color: #4c36af; line-height: 25px; font-size: 18px">{{ $details['title'] }}</p>
        <p style="margin-bottom: 40px; color: #555; line-height: 25px; font-size: 15px">
        Bonjour, <br>
        Nous vous avons définir un nouveau mot de passe suite à la demande de réinitialisation de votre mot de passe. <br>
        Votre nouveau mot de passe est :  {{ $details['password'] }}. <br>
        N'oubliez pas de le changer une fois connectée.
        </p>

        <p style="margin-bottom: 10px; text-align: justify; color: #555; line-height: 25px; font-size: 15px">CDN, Luttons tous contre le rechauffement climatique !</p>
        <p style="margin-bottom: 5px; color: #555; line-height: 25px; font-size: 15px">Cordialement,</p>
        <p style="margin-top: 0px; color: #555; line-height: 25px; font-size: 15px">CONTRIBUTION DETERMINEE AU NIVEAU NATIONAL !</p>

</body>
</html>
