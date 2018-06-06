<?php

# Formularerstellung
$parseData['form:open'] = form_open('angocr/index', array('name' => 'login','class' => 'form'));
$parseData['form:benutzername'] = form_input('benutzername', $benutzername, 'class="text benutzername"');
$parseData['form:passwort'] = form_password('passwort', $passwort, 'class="text passwort"');
$parseData['form:close'] = form_close();

$parseData['form:errors'] = validation_errors();

$parseData['formular'] = parse('lgi/formular2.tpl', $parseData, TRUE);


render_layout($parseData, 'auth');

/* End of file index.php */
/* Location: ./system/application/views/lgi/index.php */