<?php

function getSpecificEvent($eventid) {
    global $database;
    $event = $database->get('events', '*', ['id' => $eventid]);
    $page .= '
<div style="position: absolute; right: 0; margin-top: -48;">
    <p>Date: ' . date("l, F j, Y", strtotime($event['date'])) . '</p>
</div>
<div class="container">
    <div class="page-header">
        <h1>' . $event['name'] . '</h1>
    </div>
    <div class="col-md-6">
        <p class="lead">Synth selvage Shoreditch tousled, Austin keffiyeh Wes Anderson quinoa small batch fanny pack retro fixie master cleanse. Authentic squid brunch Kickstarter, asymmetrical iPhone church-key put a bird on it umami fingerstache post-ironic pickled irony artisan. Blue Bottle +1 squid crucifix, Tumblr fashion axe seitan Williamsburg kitsch McSweeney\'s. Wayfarers fixie retro American Apparel, jean shorts photo booth letterpress 8-bit church-key Tonx Pinterest blog Schlitz raw denim. Hella pour-over authentic tousled before they sold out put a bird on it. PBR Wes Anderson 3 wolf moon fanny pack mumblecore. Pinterest single-origin coffee Tumblr you probably haven\'t heard of them, hella Marfa Kickstarter keytar put a bird on it Etsy food truck brunch.</p>
    </div>
    <div class="col-md-6">
        <div>
            <h2>Projected Hours: ' . $event['hours'] . '</h2>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <p>Current attendees</p>
            </div>
            <ul class="list-group">';
    foreach (json_decode($event['members']) as $id) {
        $page .= '<li class="list-group-item">' . $database->get('members', 'name', ['id' => $id]) . '</li>';
    }
    $page .= '
            </ul>
        </div>
    </div>
</div>';
    Page::write($page);
}
?>
