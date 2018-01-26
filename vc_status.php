<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <style>
      td, th {padding:3px 7px;border-bottom:1px solid #aaa}
    </style>
  </head>
  <body>
    <h1>Version Controller status</h1>
    <table cellspacing="0">
    <tr><th>Setting</th><th>Value</th></tr>
    <?php
    echo('<tr><td>Default version</td><td>'.DEFAULT_VERSION.'</td></tr>');
    echo('<tr><td>Versions directory</td><td>'.VERSIONS_DIRECTORY.'</td></tr>');
    echo('<tr><td>Root file</td><td>'.ROOT_FILE.'</td></tr>');
    echo('<tr><td>Serial key cookie name</td><td>'.SERIAL_KEY_COOKIE_NAME.'</td></tr>');
    echo('<tr><td>Random key cookie name</td><td>'.RANDOM_KEY_COOKIE_NAME.'</td></tr>');
    echo('<tr><td>Disable site</td><td>'.DISABLE_SITE.'</td></tr>');
    echo('<tr><td>Disable pass cookie name</td><td>'.DISABLE_PASS_COOKIE_NAME.'</td></tr>');
    echo('<tr><td>Disable pass cookie value</td><td>'.DISABLE_PASS_COOKIE_VALUE.'</td></tr>');
    echo('<tr><td>Disable reason</td><td>'.DISABLE_REASON.'</td></tr>');
    echo('<tr><td>Enable debug</td><td>'.(ENABLE_DEBUG ? 'true' : 'false').'</td></tr>');
    ?>
    </table>
    <hr />
    Version Controller <?php echo(VC_VERSION) ?> by Marcin Szwarc
  </body>
</html>