<?php
// Assume $userRole contains the role of the logged-in user (Admin or Normal)
$userRole = 'Admin'; // Replace this with your actual logic to fetch the user's role

// Define menu options based on the user's role
$menuOptions = array(
    'Admin' => array(
        array('href' => 'alerts.html', 'text' => 'Alerts'),
        array('href' => 'buttons.html', 'text' => 'Buttons'),
        array('href' => 'dropdowns.html', 'text' => 'Dropdowns'),
        array('href' => 'modals.html', 'text' => 'Modals'),
        array('href' => 'popovers.html', 'text' => 'Popovers'),
        array('href' => 'progress-bar.html', 'text' => 'Progress Bars'),
    ),
    'Normal' => array(
        array('href' => 'alerts.html', 'text' => 'Alerts'),
    )
);

// Determine the menu options based on the user's role
if (isset($menuOptions[$userRole])) {
    $menuItems = $menuOptions[$userRole];
} else {
    // Default to Normal role options if the role is not recognized
    $menuItems = $menuOptions['Normal'];
}
?>

<!-- Display menu based on user's role -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
        aria-expanded="true" aria-controls="collapseBootstrap">
        <i class="far fa-fw fa-window-maximize"></i>
        <span>Raise Request (T3)</span>
    </a>
    <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <?php foreach ($menuItems as $menuItem) : ?>
                <a class="collapse-item" href="<?php echo $menuItem['href']; ?>"><?php echo $menuItem['text']; ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</li>
