<?php

// Path: ajax_msg_contact.php
// Nous permet d'afficher d'avantage les messages reçus.


// Services
require_once 'services/utils.php';
require_once 'services/Session.php';

// Models
require_once 'models/Contact.php';

$getNext = new Contact;

$getNext = $getNext->getTEST($_GET['nb'], 3);

foreach ($getNext as $contact) :
?>

    <td>
        <?= htmlspecialchars($contact['id']); ?>
    </td>
    <td>
        <?= htmlspecialchars($contact['name']); ?>
    </td>
    <td>
        <?= htmlspecialchars($contact['mail']); ?>
    </td>
    <td>
        <?= htmlspecialchars($contact['phone']); ?>
    </td>
    <td>
        <?= htmlspecialchars($contact['subject']); ?>
    </td>
    <td>
        <?= htmlspecialchars($contact['content']); ?>
    </td>
    <td>
        <?= htmlspecialchars($contact['created_at']); ?>
    </td>
<?php
endforeach;
?>