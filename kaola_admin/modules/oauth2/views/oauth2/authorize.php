<html>
  <head>Authorize</head>
  <body>
    <form method="post" action="authorize">
      <?php foreach ($auth_params as $k => $v) { ?>
      <input type="hidden" name="<?php echo $k ?>" value="<?php echo $v ?>" />
      <?php } ?>
      Do you authorize the app to do its thing?
      <p>
        <input type="submit" name="accept" value="Yep" />
        <input type="submit" name="accept" value="Nope" />
      </p>
    </form>
  </body>
</html>