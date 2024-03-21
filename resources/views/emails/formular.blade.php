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
        Vous venez d'être ajouter le formulaire {{ $details['formular']['name'] }} par CDN
        </p>

        <p style="margin-bottom: 10px; text-align: justify; color: #555; line-height: 25px; font-size: 15px">CDN, Luttons tous contre le rechauffement climatique !</p>
        <p style="margin-bottom: 5px; color: #555; line-height: 25px; font-size: 15px">Cordialement,</p>
        <p style="margin-top: 0px; color: #555; line-height: 25px; font-size: 15px">CONTRIBUTION DETERMINEE AU NIVEAU NATIONAL !</p>

</body>
</html>
