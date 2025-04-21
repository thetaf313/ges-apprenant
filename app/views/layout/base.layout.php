<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sonatel Academy' ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Contenu principal qui sera remplacé par les vues -->
    <?= $content ?? '' ?>
    
    <!-- Pied de page ou scripts communs -->
    <script src="assets/js/main.js"></script>
</body>
</html>