<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mogular Expretus</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
  <style>
    input {
      font-family: Consolas, 'Courier New', Courier, monospace;
    }
  </style>
</head>

<body class="container is-max-desktop p-5">
  <h1 class="block title is-1">Mogular Expretus</h1>
  <p class="block">You know regular expressions? You know <a href="https://fr.wikipedia.org/wiki/Motus_(jeu_t%C3%A9l%C3%A9vis%C3%A9)">Motus</a>? Well, you're ready to go. <strong>The regex you have to find is exactly 10 characters long.</strong> (without boundaries)</p>
  <form method="POST" class="block">
    <p class="field control is-expanded">
      <label class="label">
        Regex
        <span class="field has-addons">
          <span class="control"><span class="button is-static">/</span></span>
          <span class="control is-expanded">
            <input type="text" name="regex" class="input" required maxlength="10" value="<?= isset($_POST['regex']) ? htmlspecialchars($_POST['regex']) : '' ?>">
          </span>
          <span class="control"><span class="button is-static">/</span></span>
        </span>
      </label>
    </p>
    <p class="field">
      <button class="button is-link">Run</button>
    </p>
  </form>
  <?php

  function matches(string $word): bool
  {
    if (!isset($_POST['regex'])) return false;
    return @preg_match('/' . $_POST['regex'] . '/', $word);
  }

  $victory = true;
  const shouldMatch = ['a1', '-7', 'x9', 'q!3', 'b2', 'g!0', 'x-4', 'k5', 'l!0', '-!3'];
  const shouldNotMatch = ['y1', 'gg', '-', 'e!!2',  '!', '44', 'a', 'z9', '5k', '!0'];
  ?>
  <div class="block columns">
    <div class="column">
      <div class="panel is-success">
        <h3 class="panel-heading">Must match</h3>
        <?php foreach (shouldMatch as $word) {
          $matches = matches($word);
          $victory = $victory && $matches;
          echo '<label class="panel-block"><input type="checkbox" disabled' . ($matches ? ' checked' : '') . '>' . $word . '</label>';
        } ?>
      </div>
    </div>
    <div class="column">
      <div class="panel is-danger">
        <h3 class="panel-heading">Must not match</h3>
        <?php foreach (shouldNotMatch as $word) {
          $matches = matches($word);
          $victory = $victory && !$matches;
          echo '<label class="panel-block"><input type="checkbox" disabled' . ($matches ? ' checked' : '') . '>' . $word . '</label>';
        } ?>
      </div>
    </div>
  </div>
  <?php if (isset($_POST['regex']) && strlen($_POST['regex']) == 10 && $victory) { ?>
    <p class="block notification is-success">
      Well done! <?= file_get_contents('./flag.txt') ?>
    </p>
  <?php } ?>
</body>

</html>
