<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $details['subject'] }}</title>
</head>
<body>


    <div style="background-color: #FAFAFA; width: 100%; font-family: 'Arial', 'Helvetica Neue', 'Helvetica', sans-serif; box-sizing: border-box; padding: 25px; margin: 0;">

        <div style="text-align: center">
            <img src="{{ asset('assets/images/logo_cadrevie.png') }}" style="max-height: 150px" alt="">
        </div>

        <p style="margin-bottom: 25px; color: #4c36af; line-height: 25px; font-size: 18px">{{ $details['title'] }}</p>
        <p style="margin-bottom: 40px; color: #555; line-height: 25px; font-size: 15px">
            Bonjour, <br>
            Vous venez d'être invité à participer au sondage {{ $details['survey']['name'] }} par CDN
        </p>

        <p style="margin: 30px 0px; color: #555; line-height: 25px; font-size: 15px">
            Les informations contenues dans ce message et les pièces jointes (ci-après dénommés le message) sont confidentielles et peuvent être couvertes par le secret professionnel. Si vous n'êtes pas le destinataire de ce message, il vous est interdit de le copier, de le faire suivre, de le divulguer ou d'en utiliser tout ou partie. Si vous avez reçu ce message par erreur, nous vous remercions de le supprimer de votre système, ainsi que toutes ses copies, et d'en avertir immédiatement le Ministère de Cadre de Vie et de Développement Durable du Bénin, par message de retour. Il est impossible de garantir que les communications par messagerie électronique arrivent en temps utile, sont sécurisées ou dénuées de toute erreur, altération, falsification ou virus. En conséquence, le Ministère de Cadre de Vie et de Développement Durable du Bénin décline toute responsabilité du fait des erreurs, altérations, falsifications ou omissions qui pourraient en résulter. Le contenu de ce message ne représente en aucun cas un engagement de la part de le Ministère de Cadre de Vie et de Développement Durable du Bénin. Toute publication, utilisation ou diffusion, même partielle, doit être autorisée préalablement.
        </p>

        <p style="margin-bottom: 10px; text-align: justify; color: #555; line-height: 25px; font-size: 15px">CDN, Luttons tous contre le rechauffement climatique !</p>
        <p style="margin-bottom: 5px; color: #555; line-height: 25px; font-size: 15px">Cordialement,</p>
        <p style="margin-top: 0px; color: #555; line-height: 25px; font-size: 15px">CONTRIBUTION DETERMINEE AU NIVEAU NATIONAL !</p>

</body>
</html>
