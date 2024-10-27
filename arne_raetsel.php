<?php
/*
Plugin Name: Arne's GW2-Riddle
Description: Users upload screenshots that are partially displayed and other users have to guess the location where it's taken.
Version: 1.2.8
Author: Arne
License: GPL3
*/

global $arne_raetsel_version;
$arne_raetsel_version = 2;

add_shortcode( 'gw2_riddle', 'arne_raetsel_display' );
add_shortcode( 'gw2_riddle_explain', 'arne_raetsel_explain' );
add_action( 'admin_menu', 'arne_raetsel_menu' );

add_action('wp_ajax_get_wp', 'arne_raetsel_ajax');
add_action('wp_ajax_get_wp', 'arne_raetsel_ajax');
add_action('wp_enqueue_scripts', 'arne_raetsel_scripts');

register_activation_hook(__FILE__,'arne_raetsel_activation');
if (get_option('arne_raetsel_version') != $arne_raetsel_version) arne_raetsel_activation();

load_plugin_textdomain( 'arne_raetsel', false, basename( dirname( __FILE__ ) ) . '/languages/' );


// Globale Zonen und Wegmarken

$region[__("Black Citadel",'arne_raetsel')]          = array(__('Ascalon','arne_raetsel'),             array(__("Bane Waypoint",'arne_raetsel'), __("Diessa Gate Waypoint",'arne_raetsel'), __("Factorium Waypoint",'arne_raetsel'), __("Gladium Waypoint",'arne_raetsel'), __("Hero's Waypoint",'arne_raetsel'), __("Imperator's Waypoint",'arne_raetsel'), __("Junker's Waypoint",'arne_raetsel'), __("Ligacus Aquilo Waypoint",'arne_raetsel'), __("Memorial Waypoint",'arne_raetsel'), __("Mustering Ground Waypoint",'arne_raetsel'), __("Ruins of Rin Waypoint",'arne_raetsel')));
$region[__("Blazeridge Steppes",'arne_raetsel')]     = array(__('Ascalon','arne_raetsel'),             array(__("Behem Waypoint",'arne_raetsel'), __("Brandview Waypoint",'arne_raetsel'), __("Brokentooth Waypoint",'arne_raetsel'), __("Expanse Waypoint",'arne_raetsel'), __("Gastor Gullet Waypoint",'arne_raetsel'), __("Guardian Stone Waypoint",'arne_raetsel'), __("Kinar Fort Waypoint",'arne_raetsel'), __("Kindling Waypoint",'arne_raetsel'), __("Lowland Burns Waypoint",'arne_raetsel'), __("Lunk Kraal Waypoint",'arne_raetsel'), __("Refuge Sanctum Waypoint",'arne_raetsel'), __("Soot Road Waypoint",'arne_raetsel'), __("Splintercrest Fort Waypoint",'arne_raetsel'), __("Steeleye Waypoint",'arne_raetsel'), __("Terra Carorunda Waypoint",'arne_raetsel'), __("The Last Whiskey Bar Waypoint",'arne_raetsel'), __("Tumok's Waypoint",'arne_raetsel'), __("Twin Sisters Waypoint",'arne_raetsel')));
$region[__("Bloodtide Coast",'arne_raetsel')]        = array(__('Kryta','arne_raetsel'),               array(__("Archen Foreland Waypoint",'arne_raetsel'), __("Barrier Camp Waypoint",'arne_raetsel'), __("Bogside Camp Waypoint",'arne_raetsel'), __("Castavall Waypoint",'arne_raetsel'), __("Deadend Waypoint",'arne_raetsel'), __("Firthside Vigil Waypoint",'arne_raetsel'), __("Jelako Waypoint",'arne_raetsel'), __("Laughing Gull Waypoint",'arne_raetsel'), __("Lostwreck Waypoint",'arne_raetsel'), __("Marshwatch Haven Waypoint",'arne_raetsel'), __("Mournful Waypoint",'arne_raetsel'), __("Remanda Waypoint",'arne_raetsel'), __("Sorrowful Waypoint",'arne_raetsel'), __("Stormbluff Waypoint",'arne_raetsel'), __("Whisperwill Waypoint",'arne_raetsel')));
$region[__("Brisban Wildlands",'arne_raetsel')]      = array(__('Maguuma Jungle','arne_raetsel'),      array(__("Brilitine Waypoint",'arne_raetsel'), __("East End Waypoint",'arne_raetsel'), __("Gallowfields Waypoint",'arne_raetsel'), __("Hillstead Waypoint",'arne_raetsel'), __("Mirkrise Waypoint",'arne_raetsel'), __("Mrot Boru Waypoint",'arne_raetsel'), __("Proxemics Lab Waypoint",'arne_raetsel'), __("Seraph Observers Waypoint",'arne_raetsel'), __("Triforge Point Waypoint",'arne_raetsel'), __("Tunnels Waypoint",'arne_raetsel'), __("Ulta Metamagicals Waypoint",'arne_raetsel'), __("Watchful Source Waypoint",'arne_raetsel'), __("Wendon Waypoint",'arne_raetsel')));
$region[__("Caledon Forest",'arne_raetsel')]         = array(__('Maguuma Jungle','arne_raetsel'),      array(__("Astorea Waypoint",'arne_raetsel'), __("Brigid's Overlook Waypoint",'arne_raetsel'), __("Caer Astorea Waypoint",'arne_raetsel'), __("Caledon Haven Waypoint",'arne_raetsel'), __("Falias Thorpe Waypoint",'arne_raetsel'), __("Gleaner's Cove Waypoint",'arne_raetsel'), __("Hamlet of Annwen Waypoint",'arne_raetsel'), __("Kraitbane Haven Waypoint",'arne_raetsel'), __("Lionguard Waystation Waypoint",'arne_raetsel'), __("Mabon Waypoint",'arne_raetsel'), __("Sleive's Waypoint",'arne_raetsel'), __("Sperrins Waypoint",'arne_raetsel'), __("Spiral Waypoint",'arne_raetsel'), __("Titan's Staircase Waypoint",'arne_raetsel'), __("Town of Cathal Waypoint",'arne_raetsel'), __("Twilight Arbor Waypoint",'arne_raetsel'), __("Wardenhurst Waypoint",'arne_raetsel'), __("Wychmire Waypoint",'arne_raetsel')));
$region[__("Cursed Shore",'arne_raetsel')]           = array(__('Ruins of Orr','arne_raetsel'),        array(__("Anchorage Waypoint",'arne_raetsel'), __("Arah Waypoint",'arne_raetsel'), __("Caer Shadowfain Waypoint",'arne_raetsel'), __("Gavbeorn's Waypoint",'arne_raetsel'), __("Jofast's Waypoint",'arne_raetsel'), __("Meddler's Waypoint",'arne_raetsel'), __("Murdered Dreams Waypoint",'arne_raetsel'), __("Penitent Waypoint",'arne_raetsel'), __("Pursuit Pass Waypoint",'arne_raetsel'), __("R&D Waypoint",'arne_raetsel'), __("Shelter's Gate Waypoint",'arne_raetsel'), __("Shipwreck Rock Waypoint",'arne_raetsel'), __("Verdance Waypoint",'arne_raetsel')));
$region[__("Diessa Plateau",'arne_raetsel')]         = array(__('Ascalon','arne_raetsel'),             array(__("Blackblade Waypoint",'arne_raetsel'), __("Blasted Moors Waypoint",'arne_raetsel'), __("Bloodcliff Waypoint",'arne_raetsel'), __("Bloodsaw Mill Waypoint",'arne_raetsel'), __("Breached Wall Waypoint",'arne_raetsel'), __("Breachwater Waypoint",'arne_raetsel'), __("Butcher's Block Waypoint",'arne_raetsel'), __("Charradis Estate Waypoint",'arne_raetsel'), __("Charrgate Haven Waypoint",'arne_raetsel'), __("Dawnright Estate Waypoint",'arne_raetsel'),__("Font of Rhand Waypoint",'arne_raetsel'), __("Incendio Waypoint",'arne_raetsel'), __("Manbane's Waypoint",'arne_raetsel'), __("Nageling Waypoint",'arne_raetsel'), __("Nemus Grove Waypoint",'arne_raetsel'), __("Nolan Waypoint",'arne_raetsel'), __("Oldgate Waypoint",'arne_raetsel'), __("Redreave Mill Waypoint",'arne_raetsel'), __("Sanctum Waypoint",'arne_raetsel')));
$region[__("Divinity's Reach",'arne_raetsel')]       = array(__('Kryta','arne_raetsel'),               array(__("Balthazar Waypoint",'arne_raetsel'), __("Collapse Waypoint",'arne_raetsel'), __("Commons Waypoint",'arne_raetsel'), __("Dwayna Waypoint",'arne_raetsel'), __("Grenth Waypoint",'arne_raetsel'), __("Kormir Waypoint",'arne_raetsel'), __("Lyssa Waypoint",'arne_raetsel'), __("Melandru Waypoint",'arne_raetsel'), __("Ministers Waypoint",'arne_raetsel'), __("Ossan Waypoint",'arne_raetsel'), __("Palace Waypoint",'arne_raetsel'), __("Rurikton Waypoint",'arne_raetsel'), __("Salma Waypoint",'arne_raetsel')));
$region[__("Dredgehaunt Cliffs",'arne_raetsel')]     = array(__('Shiverpeak Mountains','arne_raetsel'),array(__("Dociu Waypoint",'arne_raetsel'), __("Frostland Waypoint",'arne_raetsel'), __("Granite Citadel Waypoint",'arne_raetsel'), __("Graupel Waypoint",'arne_raetsel'), __("Grey Road Waypoint",'arne_raetsel'), __("Havfrue Basin Waypoint",'arne_raetsel'), __("Hessdallen Kenning Waypoint",'arne_raetsel'), __("Kenning Testing Ground",'arne_raetsel'), __("Mountain's Tail Waypoint",'arne_raetsel'), __("Nottowr Fault Waypoint",'arne_raetsel'), __("Seven Pines Waypoint",'arne_raetsel'), __("Sorrow's Embrace Waypoint",'arne_raetsel'), __("Steelbrachen Waypoint",'arne_raetsel'), __("Toran Hollow Waypoint",'arne_raetsel'), __("Travelen's Waypoint",'arne_raetsel'), __("Tribulation Waypoint",'arne_raetsel'), __("Wide Expanse Waypoint",'arne_raetsel'), __("Wyrmblood Waypoint",'arne_raetsel')));
$region[__("Fields of Ruin",'arne_raetsel')]         = array(__('Ascalon','arne_raetsel'),             array(__("Deathblade's Watch Waypoint",'arne_raetsel'), __("Fallen Angels Garrison Waypoint",'arne_raetsel'), __("Fangfury Watch Waypoint",'arne_raetsel'), __("Forlorn Gate Waypoint",'arne_raetsel'), __("Hawkgates Waypoint",'arne_raetsel'), __("Helliot Mine Waypoint",'arne_raetsel'), __("Kestrel Waypoint",'arne_raetsel'), __("Ogre Road Waypoint",'arne_raetsel'), __("Rosko's Campsite Waypoint",'arne_raetsel'), __("Skoll's Bivouac Waypoint",'arne_raetsel'), __("Spotter's Waypoint",'arne_raetsel'), __("Summit Waypoint",'arne_raetsel'), __("Tenaebron Waypoint",'arne_raetsel'), __("Thunderbreak Waypoint",'arne_raetsel'), __("Tyler's Bivouac Waypoint",'arne_raetsel'), __("Vulture's Waypoint",'arne_raetsel'), __("Wreckage of Bloodgorge Watch Waypoint",'arne_raetsel')));
$region[__("Fireheart Rise",'arne_raetsel')]         = array(__('Ascalon','arne_raetsel'),             array(__("Apostate Waypoint",'arne_raetsel'), __("Breaktooth's Waypoint",'arne_raetsel'), __("Forlorn Waypoint",'arne_raetsel'), __("Havoc Waypoint",'arne_raetsel'), __("Icespear's Waypoint",'arne_raetsel'), __("Keeper's Waypoint",'arne_raetsel'), __("Pig Iron Waypoint",'arne_raetsel'), __("Rustbowl Waypoint",'arne_raetsel'), __("Sati Waypoint",'arne_raetsel'), __("Senecus Castrum Waypoint",'arne_raetsel'), __("Severed Breach Waypoint",'arne_raetsel'), __("Simurgh Waypoint",'arne_raetsel'), __("Snow Ridge Camp Waypoint",'arne_raetsel'), __("Switchback Waypoint",'arne_raetsel'), __("The Flame Citadel Waypoint",'arne_raetsel'), __("Tuyere Command Post Waypoint",'arne_raetsel'), __("Vidius Castrum Waypoint",'arne_raetsel'), __("Vorgas Garrison Waypoint",'arne_raetsel')));
$region[__("Frostgorge Sound",'arne_raetsel')]       = array(__('Shiverpeak Mountains','arne_raetsel'),array(__("Arundon Waypoint",'arne_raetsel'), __("Blue Ice Shining Waypoint",'arne_raetsel'), __("Dimotiki Waypoint",'arne_raetsel'), __("Drakkar Waypoint",'arne_raetsel'), __("Earthshake Waypoint",'arne_raetsel'), __("Groznev Waypoint",'arne_raetsel'), __("Highpeaks Waypoint",'arne_raetsel'), __("Honor of the Waves Waypoint",'arne_raetsel'), __("Ice Floe Waypoint",'arne_raetsel'), __("Path of Starry Skies Waypoint",'arne_raetsel'), __("Ridgerock Camp Waypoint",'arne_raetsel'), __("Skyheight Steading Waypoint",'arne_raetsel'), __("Slough of Despond Waypoint",'arne_raetsel'), __("Twoloop Waypoint",'arne_raetsel'), __("Watchful Waypoint",'arne_raetsel'), __("Yak's Bend Waypoint",'arne_raetsel')));
$region[__("Gendarran Fields",'arne_raetsel')]       = array(__('Kryta','arne_raetsel'),               array(__("Almuten Waypoint",'arne_raetsel'), __("Applenook Hamlet Waypoint",'arne_raetsel'), __("Ascalon Settlement Waypoint",'arne_raetsel'), __("Blood Hill Waypoint",'arne_raetsel'), __("Bloodfields Waypoint",'arne_raetsel'), __("Brigantine Waypoint",'arne_raetsel'), __("Broadhollow Waypoint",'arne_raetsel'), __("Cornucopian Fields Waypoint",'arne_raetsel'), __("First Haven Waypoint",'arne_raetsel'), __("Icegate Waypoint",'arne_raetsel'), __("Junction Haven Waypoint",'arne_raetsel'), __("Lionbridge Waypoint",'arne_raetsel'), __("Nebo Terrace Waypoint",'arne_raetsel'), __("Northfields Waypoint",'arne_raetsel'), __("Oogooth Waypoint",'arne_raetsel'), __("Provern Shore Waypoint",'arne_raetsel'), __("Snowblind Waypoint",'arne_raetsel'), __("Stoneguard Gate Waypoint",'arne_raetsel'), __("Talajian Waypoint",'arne_raetsel'), __("Traveler's Dale Waypoint",'arne_raetsel'), __("Vigil Keep Waypoint",'arne_raetsel'), __("Winter Haven Waypoint",'arne_raetsel')));
$region[__("Harathi Hinterlands",'arne_raetsel')]    = array(__('Kryta','arne_raetsel'),               array(__("Arca Waypoint",'arne_raetsel'), __("Arcallion Waypoint",'arne_raetsel'), __("Barricade Camp Waypoint",'arne_raetsel'), __("Bridgewatch Camp Waypoint",'arne_raetsel'), __("Cloven Hoof Waypoint",'arne_raetsel'), __("Demetra Waypoint",'arne_raetsel'), __("Faun's Waypoint",'arne_raetsel'), __("Grey Gritta's Post Waypoint",'arne_raetsel'), __("Junction Camp Waypoint",'arne_raetsel'), __("Nightguard Waypoint",'arne_raetsel'), __("Recovery Camp Waypoint",'arne_raetsel'), __("Seraph's Landing Waypoint",'arne_raetsel'), __("Shieldbluff Waypoint",'arne_raetsel'), __("Trebusha's Overlook Waypoint",'arne_raetsel'), __("Wynchona Rally Point Waypoint",'arne_raetsel')));
$region[__("Hoelbrak",'arne_raetsel')]               = array(__('Shiverpeak Mountains','arne_raetsel'),array(__("Bear Waypoint",'arne_raetsel'), __("Eastern Watchpost Waypoint",'arne_raetsel'), __("Great Lodge Waypoint",'arne_raetsel'), __("Hero's Compass Waypoint",'arne_raetsel'), __("Legends Waypoint",'arne_raetsel'), __("Might and Main Waypoint",'arne_raetsel'), __("Peeta's Waypoint",'arne_raetsel'), __("Raven Waypoint",'arne_raetsel'), __("Shelter Rock Waypoint",'arne_raetsel'), __("Snow Leopard Waypoint",'arne_raetsel'), __("Southern Watchpost Waypoint",'arne_raetsel'), __("Trade Commons Waypoint",'arne_raetsel'), __("Upper Balcony Waypoint",'arne_raetsel'), __("Wolf Waypoint",'arne_raetsel')));
$region[__("Iron Marches",'arne_raetsel')]           = array(__('Ascalon','arne_raetsel'),             array(__("Bloodfin Lake Waypoint",'arne_raetsel'), __("Brandwatch Encampment Waypoint",'arne_raetsel'), __("Bulwark Waypoint",'arne_raetsel'), __("Dewclaw Waypoint",'arne_raetsel'), __("Firewatch Encampment Waypoint",'arne_raetsel'), __("Gladefall Waypoint",'arne_raetsel'), __("Grostogg's Kraal Waypoint",'arne_raetsel'), __("Hellion Waypoint",'arne_raetsel'), __("Old Piken Ruins Waypoint",'arne_raetsel'), __("Sleekfur Encampment Waypoint",'arne_raetsel'), __("Town of Cowlfang's Star Waypoint",'arne_raetsel'), __("Village of Scalecatch Waypoint",'arne_raetsel'), __("Viper's Run Waypoint",'arne_raetsel'), __("Warhound Village Waypoint",'arne_raetsel')));
$region[__("Kessex Hills",'arne_raetsel')]           = array(__('Kryta','arne_raetsel'),               array(__("Cavernhold Camp Waypoint",'arne_raetsel'), __("Cereboth Waypoint",'arne_raetsel'), __("Darkwound Waypoint",'arne_raetsel'), __("Delanian Waypoint",'arne_raetsel'), __("Earthworks Camp Waypoint",'arne_raetsel'), __("Fort Salma Waypoint",'arne_raetsel'), __("Gap Waypoint",'arne_raetsel'), __("Greyhoof Camp Waypoint",'arne_raetsel'), __("Halacon Waypoint",'arne_raetsel'), __("Ireko Tradecamp Waypoint",'arne_raetsel'), __("Kessex Haven Waypoint",'arne_raetsel'), __("Meadows Waypoint",'arne_raetsel'), __("Moogooloo Waypoint",'arne_raetsel'), __("Overlake Haven Waypoint",'arne_raetsel'), __("Overlord's Waypoint",'arne_raetsel'), __("Shadowheart Site Waypoint",'arne_raetsel'), __("Sojourner's Waypoint",'arne_raetsel'), __("Viathan Waypoint",'arne_raetsel')));
$region[__("Lion's Arch",'arne_raetsel')]            = array(__('Kryta','arne_raetsel'),               array(__("Bloodcoast Ward Waypoint",'arne_raetsel'), __("Canal Ward Waypoint",'arne_raetsel'),__("Claw Island Portage Waypoint",'arne_raetsel'),__("Diverse Ledges Waypoint",'arne_raetsel'),__("Eastern Ward Waypoint",'arne_raetsel'),__("Farshore Waypoint",'arne_raetsel'), __("Fort Marriner Waypoint",'arne_raetsel'), __("Gate Hub Plaza Waypoint",'arne_raetsel'), __("Lion's Shadow Inn Waypoint",'arne_raetsel'), __("Sanctum Harbor Waypoint",'arne_raetsel'), __("Smuggler's Waypoint",'arne_raetsel'), __("Trader's Forum Waypoint",'arne_raetsel'), __("Western Ward Waypoint",'arne_raetsel')));
$region[__("Lornar's Pass",'arne_raetsel')]          = array(__('Shiverpeak Mountains','arne_raetsel'),array(__("Afgar's Waypoint",'arne_raetsel'), __("Cascade Bridge Waypoint",'arne_raetsel'), __("Demon's Maw Waypoint",'arne_raetsel'), __("Durmand Priory Waypoint",'arne_raetsel'), __("False Lake Waypoint",'arne_raetsel'), __("Guutra's Homestead Waypoint",'arne_raetsel'), __("Icedevil's Waypoint",'arne_raetsel'), __("Lamentation Waypoint",'arne_raetsel'), __("Mistriven Waypoint",'arne_raetsel'), __("Nentor Waypoint",'arne_raetsel'), __("Pinnacle Enclave Waypoint",'arne_raetsel'), __("Refuge Peak Waypoint",'arne_raetsel'), __("Stonescatter Waypoint",'arne_raetsel'), __("Thunderhorns Waypoint",'arne_raetsel'), __("Vanjir's Stead Waypoint",'arne_raetsel'), __("Winterthaw Waypoint",'arne_raetsel')));
$region[__("Malchor's Leap",'arne_raetsel')]         = array(__('Ruins of Orr','arne_raetsel'),        array(__("Blighted Arch Waypoint",'arne_raetsel'), __("Colonnade Waypoint",'arne_raetsel'), __("Doric's Waypoint",'arne_raetsel'), __("Lights Waypoint",'arne_raetsel'), __("Lyssa Waypoint",'arne_raetsel'), __("Murmur Waypoint",'arne_raetsel'), __("Pagga's Waypoint",'arne_raetsel'), __("Tempest Waypoint",'arne_raetsel'), __("Union Waypoint",'arne_raetsel'), __("Valley of Lyss Waypoint",'arne_raetsel'), __("Versoconjouring Waypoint",'arne_raetsel'), __("Waste Hollows Waypoint",'arne_raetsel'), __("Wren Waypoint",'arne_raetsel')));
$region[__("Metrica Province",'arne_raetsel')]       = array(__('Maguuma Jungle','arne_raetsel'),      array(__("Akk Wilds Waypoint",'arne_raetsel'), __("Anthill Waypoint",'arne_raetsel'), __("Artergon Waypoint",'arne_raetsel'), __("Arterium Haven Waypoint",'arne_raetsel'), __("Cuatl Waypoint",'arne_raetsel'), __("Desider Atum Waypoint",'arne_raetsel'), __("Hexane Regrade Waypoint",'arne_raetsel'), __("Hydrone Unit Waypoint",'arne_raetsel'), __("Jeztar Falls Waypoint",'arne_raetsel'), __("Loch Waypoint",'arne_raetsel'), __("Michotl Grounds Waypoint",'arne_raetsel'), __("Muridian Waypoint",'arne_raetsel'), __("Old Golem Factory Waypoint",'arne_raetsel'), __("Rana Landing Complex Waypoint",'arne_raetsel'), __("Soren Draa Waypoint",'arne_raetsel'), __("Survivor's Encampment Waypoint",'arne_raetsel')));
$region[__("Mount Maelstrom",'arne_raetsel')]        = array(__('Maguuma Jungle','arne_raetsel'),      array(__("Ashen Waypoint",'arne_raetsel'), __("Avernan Waypoint",'arne_raetsel'), __("Bard's Waypoint",'arne_raetsel'), __("Broken Arrow Waypoint",'arne_raetsel'), __("Criterion Waypoint",'arne_raetsel'), __("Crucible of Eternity Waypoint",'arne_raetsel'), __("Firebreak Fort Waypoint",'arne_raetsel'),__("Gauntlet Waypoint",'arne_raetsel'), __("Govoran Waypoint",'arne_raetsel'), __("Irwin Isle Waypoint",'arne_raetsel'), __("Judgement Waypoint",'arne_raetsel'), __("Maelstrom's Waypoint",'arne_raetsel'), __("Magmatic Waypoint",'arne_raetsel'), __("Murkvale Waypoint",'arne_raetsel'), __("Old Sledge Site Waypoint",'arne_raetsel'), __("Oxbow Isle Waypoint",'arne_raetsel'), __("Spaecia Illogica Waypoint",'arne_raetsel')));
$region[__("Plains of Ashford",'arne_raetsel')]      = array(__('Ascalon','arne_raetsel'),             array(__("Adorea Waypoint",'arne_raetsel'), __("Ascalon City Waypoint",'arne_raetsel'), __("Ascalonian Catacombs Waypoint",'arne_raetsel'), __("Ashford Waypoint",'arne_raetsel'), __("Duskrend Overlook Waypoint",'arne_raetsel'), __("Feritas Waypoint",'arne_raetsel'), __("Greysteel Armory Waypoint",'arne_raetsel'), __("Guardpoint Decimus Waypoint",'arne_raetsel'), __("Irondock Shipyard Waypoint",'arne_raetsel'), __("Langmar Estate Waypoint",'arne_raetsel'), __("Loreclaw Waypoint",'arne_raetsel'), __("Martyr's Waypoint",'arne_raetsel'), __("Phasmatis Waypoint",'arne_raetsel'), __("Smokestead Waypoint",'arne_raetsel'), __("Spirit Hunter Camp Waypoint",'arne_raetsel'), __("Temperus Point Waypoint",'arne_raetsel'), __("Vault Waypoint",'arne_raetsel'), __("Vir's Gate Waypoint",'arne_raetsel'), __("Watchcrag Tower Waypoint",'arne_raetsel')));
$region[__("Queensdale",'arne_raetsel')]             = array(__('Kryta','arne_raetsel'),               array(__("Beetletun Waypoint",'arne_raetsel'), __("Claypool Waypoint",'arne_raetsel'), __("Crossing Waypoint",'arne_raetsel'), __("Fields Waypoint",'arne_raetsel'), __("Garrison Waypoint",'arne_raetsel'), __("Godslost Waypoint",'arne_raetsel'), __("Heartwood Pass Camp Waypoint",'arne_raetsel'), __("Krytan Waypoint",'arne_raetsel'), __("Ojon's Lumbermill Waypoint",'arne_raetsel'), __("Orchard Waypoint",'arne_raetsel'), __("Phinney Waypoint",'arne_raetsel'), __("Scaver Waypoint",'arne_raetsel'), __("Shaemoor Waypoint",'arne_raetsel'), __("Swamplost Haven Waypoint",'arne_raetsel'), __("Tunwatch Redoubt Waypoint",'arne_raetsel'), __("Vale Waypoint",'arne_raetsel')));
$region[__("Rata Sum",'arne_raetsel')]               = array(__('Maguuma Jungle','arne_raetsel'),      array(__("Accountancy Waypoint",'arne_raetsel'), __("Apprentice Waypoint",'arne_raetsel'), __("Auxiliary Waypoint",'arne_raetsel'), __("Incubation Waypoint",'arne_raetsel'), __("Magicat Court Waypoint",'arne_raetsel'), __("Magustan Court Waypoint",'arne_raetsel'), __("Metrical Court Waypoint",'arne_raetsel'), __("Port Waypoint",'arne_raetsel'), __("Research Waypoint",'arne_raetsel')));
$region[__("Snowden Drifts",'arne_raetsel')]         = array(__('Shiverpeak Mountains','arne_raetsel'),array(__("Exile Waypoint",'arne_raetsel'), __("Frozen Sweeps Waypoint",'arne_raetsel'), __("Highpass Haven Waypoint",'arne_raetsel'), __("Isenfall Waypoint",'arne_raetsel'), __("Lornar's Waypoint",'arne_raetsel'), __("Lost Child's Waypoint",'arne_raetsel'), __("Njordstead Waypoint",'arne_raetsel'), __("Owl Waypoint",'arne_raetsel'), __("Podaga Waypoint",'arne_raetsel'), __("Reaver's Waypoint",'arne_raetsel'), __("Scholar's Waypoint",'arne_raetsel'), __("Seraph Outriders' Waypoint",'arne_raetsel'), __("Skradden Waypoint",'arne_raetsel'), __("Snowdrift Waypoint",'arne_raetsel'), __("Snowhawk Landing Waypoint",'arne_raetsel'), __("Soderhem Steading Waypoint",'arne_raetsel'), __("Torstvedt Homestead Waypoint",'arne_raetsel'), __("Valslake Waypoint",'arne_raetsel'), __("Angvar's Trove",'arne_raetsel')));
$region[__("Southsun Cove",'arne_raetsel')]          = array(__('Kryta','arne_raetsel'),               array(__("Camp Karka Waypoint",'arne_raetsel'), __("Kiel's Outpost Waypoint",'arne_raetsel'), __("Lion Point Waypoint",'arne_raetsel'), __("Owain's Refuge Waypoint",'arne_raetsel'), __("Pearl Islet Waypoint",'arne_raetsel'), __("Pride Point Waypoint",'arne_raetsel')));
$region[__("Sparkfly Fen",'arne_raetsel')]           = array(__('Maguuma Jungle','arne_raetsel'),      array(__("Aleem's Waypoint",'arne_raetsel'), __("Brackwater Waypoint",'arne_raetsel'), __("Braggi's Stead Waypoint",'arne_raetsel'), __("Brooloonu Waypoint",'arne_raetsel'), __("Caer Brier Waypoint",'arne_raetsel'), __("Darkweather Waypoint",'arne_raetsel'), __("Dryground Waypoint",'arne_raetsel'), __("Flamefrog Waypoint",'arne_raetsel'), __("Fort Cadence Waypoint",'arne_raetsel'), __("Forvar's Waypoint",'arne_raetsel'), __("Mire Waypoint",'arne_raetsel'), __("Ocean's Gullet Waypoint",'arne_raetsel'), __("Orvar's Glen Waypoint",'arne_raetsel'), __("Saltflood Waypoint",'arne_raetsel'), __("Splintered Coast Waypoint",'arne_raetsel'), __("Toade's Head Waypoint",'arne_raetsel'), __("Zintl Holy Grounds Waypoint",'arne_raetsel')));
$region[__("Straits of Devastation",'arne_raetsel')] = array(__('Ruins of Orr','arne_raetsel'),        array(__("Bramble Pass Waypoint",'arne_raetsel'), __("Brassclaw Waypoint",'arne_raetsel'), __("Broken Spit Waypoint",'arne_raetsel'), __("Conquest Marina Waypoint",'arne_raetsel'), __("Dire Shoal Waypoint",'arne_raetsel'), __("Fort Trinity Waypoint",'arne_raetsel'), __("Glorious Victory Waypoint",'arne_raetsel'), __("Lone Post Waypoint",'arne_raetsel'), __("Plinth Timberland Waypoint",'arne_raetsel'), __("Rally Waypoint",'arne_raetsel'), __("Royal Forum Waypoint",'arne_raetsel'), __("Sentry Waypoint",'arne_raetsel'), __("Signal Peak Waypoint",'arne_raetsel'), __("Thorn Pass Waypoint",'arne_raetsel'), __("Thunderhead Waypoint",'arne_raetsel'), __("Tughra Waypoint",'arne_raetsel'), __("Underbelly Waypoint",'arne_raetsel'), __("Vesper Bell Waypoint",'arne_raetsel'), __("Waywarde Waypoint",'arne_raetsel'), __("Xenarius Waypoint",'arne_raetsel')));
$region[__("The Grove",'arne_raetsel')]              = array(__('Maguuma Jungle','arne_raetsel'),      array(__("Caledon Waypoint",'arne_raetsel'), __("Reckoner's Waypoint",'arne_raetsel'), __("Ronan's Waypoint",'arne_raetsel'), __("Upper Commons Waypoint",'arne_raetsel')));
$region[__("Timberline Falls",'arne_raetsel')]       = array(__('Shiverpeak Mountains','arne_raetsel'),array(__("Coil Waypoint",'arne_raetsel'), __("Concordia Waypoint",'arne_raetsel'), __("Eztlitl Grounds Waypoint",'arne_raetsel'), __("Foundation 86 Waypoint",'arne_raetsel'), __("Gentle River Waypoint",'arne_raetsel'), __("Gyre Rapids Waypoint",'arne_raetsel'), __("Iron Veil Waypoint",'arne_raetsel'), __("Krongar Waypoint",'arne_raetsel'), __("Nonmoa Waypoint",'arne_raetsel'), __("Ogduk Waypoint",'arne_raetsel'), __("Okarinoo Waypoint",'arne_raetsel'), __("Rankor Ruins Waypoint",'arne_raetsel'), __("Serpent Waypoint",'arne_raetsel'), __("Skale Strand Waypoint",'arne_raetsel'), __("Stormkarl Waypoint",'arne_raetsel'), __("Talus Waypoint",'arne_raetsel'), __("Thistlereed Waypoint",'arne_raetsel'), __("Valance Tutory Waypoint",'arne_raetsel'), __("White Paper Waypoint",'arne_raetsel')));
$region[__("Wayfarer Foothills",'arne_raetsel')]     = array(__('Shiverpeak Mountains','arne_raetsel'),array(__("Crossroads Waypoint",'arne_raetsel'), __("Darkriven Waypoint",'arne_raetsel'), __("Dawnrise Waypoint",'arne_raetsel'), __("Dolyak Pass Waypoint",'arne_raetsel'), __("Grawlenfjord Waypoint",'arne_raetsel'), __("Halvaunt Waypoint",'arne_raetsel'), __("Hero's Moot Waypoint",'arne_raetsel'), __("Horncall Waypoint",'arne_raetsel'), __("Krennak's Homestead",'arne_raetsel'), __("Lostvyrm Waypoint",'arne_raetsel'), __("Osenfold Waypoint",'arne_raetsel'), __("Outcast's Waypoint",'arne_raetsel'), __("Solitude Waypoint",'arne_raetsel'), __("Taigan Waypoint",'arne_raetsel'), __("Twinspur Haven Waypoint",'arne_raetsel'), __("Vendrake's Homestead Waypoint",'arne_raetsel'), __("Zelechor Hot Springs Waypoint",'arne_raetsel')));


/*
 *  MENÜ-EINTRAG
 */

function arne_raetsel_menu() {
    add_options_page( __('GW2-Screenshotriddle-Settings','arne_raetsel'), __('GW2-Screenshotriddle','arne_raetsel'), 'manage_options', 'arne-raetesel-settings', 'arne_raetsel_optionen' );
}


/*
 *  ACTIVATION AND UPDATES
 */

function arne_raetsel_activation() {
    global $arne_raetsel_version;
    $old_version = intval(get_option('arne_raetsel_version'));
    
    // Create directories
    $upload_dir = wp_upload_dir();
    $basedir = $upload_dir['basedir'];
    
    @mkdir($basedir.'/arne_riddle');
    @mkdir($basedir.'/arne_riddle/source');
    @copy(plugin_dir_path( __FILE__ ).'source/.htaccess',$basedir.'/arne_riddle/source/.htaccess');
    @mkdir($basedir.'/arne_riddle/gallery');
    @mkdir($basedir.'/arne_riddle/gallery/thumbs');
    
    // I'm afraid, it's too late...
    if ($old_version == 0) {
        @copy(plugin_dir_path( __FILE__ ).'source/upload.jpg',$basedir.'/arne_riddle/source/upload.jpg');
        @copy(plugin_dir_path( __FILE__ ).'riddle.jpg',$basedir.'/arne_riddle/riddle.jpg');
    }
    if ($old_version <= 1) {
        // Convert old DB-format to new one
        list($start,$order,$solved,$origin,$last,$solution) = unserialize(get_option('arne_riddle'));
        $userlist = unserialize(get_option('arne_riddle_user'));
        $logbuch = unserialize(get_option('arne_riddle_logbuch'));
        list($zielpunktzahl,$programm,$zeitzone,$dogallery) = unserialize(get_option('arne_riddle_settings'));

        $optionen = array();
        $optionen['start']          = $start;
        $optionen['order']          = $order;
        $optionen['solved']         = $solved;
        $optionen['origin']         = $origin;
        $optionen['last']           = $last;
        $optionen['solution']       = $solution;
        $optionen['userlist']       = $userlist;
        $optionen['logbuch']        = $logbuch;
        $optionen['zielpunktzahl']  = $zielpunktzahl;
        $optionen['programm']       = $programm;
        $optionen['dogallery']      = $dogallery;
        
        delete_option('arne_riddle');
        delete_option('arne_riddle_user');
        delete_option('arne_riddle_logbuch');
        delete_option('arne_riddle_settings');
        
        add_option("arne_riddle", serialize($optionen));
    }
    
    update_option("arne_raetsel_version", $arne_raetsel_version);
}


/*
 *  OPTIONEN
 */
 
function arne_raetsel_optionen() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    
    $upload_dir = wp_upload_dir();
    $basedir = $upload_dir['basedir'];
    $baseurl = $upload_dir['baseurl'];
    
    if (file_exists($basedir.'/arne_riddle/riddle-klein.jpg')) {
        print '<img style="float:right;padding:0 0 10px 10px;" src="' . $baseurl.'/arne_riddle/riddle-klein.jpg" />';
    }
    
    $optionen = unserialize(get_option('arne_riddle'));
    
    if (intval($optionen['zielpunktzahl']) == 0) $optionen['zielpunktzahl'] = 100;

    print '<h1>'.htmlspecialchars(__('Guild-Wars-2-Screenshotriddle','arne_raetsel')).'</h1>';
    
    
    // restart
    
    if (isset($_POST['reset-game'])) {
        $optionen['solved'] = $optionen['origin'];
        $optionen['tipps']    = array();

        copy(plugin_dir_path( __FILE__ ).'pic/default.jpg',$basedir.'/arne_riddle/riddle.jpg');
        @unlink($basedir.'/arne_riddle/riddle-klein.jpg');

        $mich = get_userdata(get_current_user_id());
        $dich = get_userdata($optionen['solved']);
        $message = sprintf(__('%s cancels actual round. %s should upload a new picture.','arne_raetsel'),$mich->display_name,$dich->display_name);
        $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
        if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
        update_option("arne_riddle", serialize($optionen));
        if ($optionen['programm']) @exec($optionen['programm'].' "[b]'.htmlspecialchars(__('Guild Riddle','arne_raetsel')).':[/b] '.$message.'"');
    }


    // change uploader

    if (isset($_POST['set-origin'])) {
        $uid = intval($_POST['user']);
        if ($uid != 0) {
            $optionen['start'] = 1;
            $optionen['solved'] = $uid;
            $optionen['tipps']    = array();

            copy(plugin_dir_path( __FILE__ ).'pic/default.jpg',$basedir.'/arne_riddle/riddle.jpg');
            @unlink($basedir.'/arne_riddle/riddle-klein.jpg');

            $mich = get_userdata(get_current_user_id());
            $dich = get_userdata($optionen['solved']);

            $message = sprintf(__('%s cancels actual round and asks %s to upload the next picture.','arne_raetsel'),$mich->display_name,$dich->display_name);
            $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
            if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
            update_option("arne_riddle", serialize($optionen));
            if ($optionen['programm']) @exec($optionen['programm'].' "[b]'.htmlspecialchars(__('Guild Riddle','arne_raetsel')).':[/b] '.$message.'"');
        }
    }


    // remove from highscores
    
    if (isset($_POST['remove-player'])) {
        $uid = intval($_POST['user']);
        if ($uid != 0) {
            unset($optionen['userlist'][$uid]);
            $mich = get_userdata(get_current_user_id());
            $dich = get_userdata($uid);

            $message = sprintf(__('%s removes %s from the highscore table.','arne_raetsel'),$mich->display_name,$dich->display_name);
            $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
            if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
            update_option("arne_riddle", serialize($optionen));
            if ($optionen['programm']) @exec($optionen['programm'].' "[b]'.htmlspecialchars(__('Guild Riddle','arne_raetsel')).':[/b] '.$message.'"');
        }
    }
    

    // start new game

    if (isset($_POST['start-new-round'])) {
        copy(plugin_dir_path( __FILE__ ).'pic/default.jpg',$basedir.'/arne_riddle/riddle.jpg');
        @unlink($basedir.'/arne_riddle/riddle-klein.jpg');
        
        $optionen['start'] = 0;
        $optionen['solved'] = 0;
        $optionen['origin'] = 0;
        $optionen['tipps']    = array();

        $optionen['logbuch'] = array();
        
        unset($optionen['start']);
        unset($optionen['order']);
        unset($optionen['solved']);
        unset($optionen['origin']);
        unset($optionen['last']);
        unset($optionen['solution']);
        unset($optionen['userlist']);
        
        $mich = get_userdata(get_current_user_id());

        $message = sprintf(__('%s starts a new round.','arne_raetsel'),$mich->display_name);
        $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
        if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
        update_option("arne_riddle", serialize($optionen));
        if ($optionen['programm']) @exec($optionen['programm'].' "[b]'.htmlspecialchars(__('Guild Riddle','arne_raetsel')).':[/b] '.$message.'"');
    }


    // set target points

    if (isset($_POST['set-target'])) {
        $z = intval($_POST['points']);
        if ($z > 0) {
            $optionen['zielpunktzahl'] = $z;
            
            $message = sprintf(__('%s sets the target points to %d','arne_raetsel'),$mich->display_name,$optionen['zielpunktzahl']);
            $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
            if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
            update_option("arne_riddle", serialize($optionen));
            if ($optionen['programm']) @exec($optionen['programm'].' "[b]'.htmlspecialchars(__('Guild Riddle','arne_raetsel')).':[/b] '.$message.'"');
        }
    }


    // set program to execute when new entry added to logbuch

    if (isset($_POST['set-exec'])) {
        $p = trim(stripslashes($_POST['programm']));
        if (strlen($p) > 0) {
            $optionen['programm'] = $p;
            update_option("arne_riddle", serialize($optionen));
        }
    }


    // set gallery settings

    if (isset($_POST['set-gallery'])) {
        $optionen['dogallery'] = intval($_POST['do-gallery']);
        update_option("arne_riddle", serialize($optionen));
        if ($optionen['dogallery'] && (!file_exists($basedir.'/arne_riddle/gallery/thumbs'))) {
            @mkdir($basedir.'/arne_riddle/gallery');
            @mkdir($basedir.'/arne_riddle/gallery/thumbs');
        }
    }

   
    // display option page
    
    print '<form method="POST" action="">';
    print '<h2>'.htmlspecialchars(__('Shortcodes','arne_raetsel')).'</h2>';
    print '<p>'.sprintf(htmlspecialchars(__('The riddle can be embedded with %s. A detailed explaination with %s.','arne_raetsel')),'<code>[gw2_riddle]</code>','<code>[gw2_riddle_explain]</code>').'</p>';
    print '<h2>'.htmlspecialchars(__('Gamemanagement','arne_raetsel')).'</h2>';
    print '<h3>'.htmlspecialchars(__('Reset Actual Round','arne_raetsel')).'</h3>';
    print '<p>'.htmlspecialchars(__('A player uploaded an inappropriate picture. Stop the actual round, nobody earns points. The according player has to upload a new picture.','arne_raetsel')).'</p>';
    print '<input type="submit" name="reset-game" value="'.htmlspecialchars(__('Reset round','arne_raetsel')).'" />';
    print '</form>';
    
    print '<form method="POST" action="">';
    print '<h3>'.htmlspecialchars(__('Change Uploader','arne_raetsel')).'</h3>';
    print '<p>'.htmlspecialchars(__('You want another player to start the next round. Cancels actual round, nobody earns points and the selected player has to upload a new picture.','arne_raetsel')).'</p>';
    $possible_players = get_users(array('fields'=>'all'));
    if ((sizeof($possible_players) > 0) && (is_array($possible_players))) {
        print '<select id="user" name="user">';
        foreach ($possible_players as $cuser) {
            if (user_can($cuser->ID,'upload_files')) {
                print '<option value="'.$cuser->ID.'">'.htmlspecialchars($cuser->display_name).'</option>';
            }
        }
        print '</select>';
    } else {
        print '<p>'.htmlspecialchars(__('No possible players with rights...','arne_raetsel')).'</p>';
    }
    print '<input type="submit" name="set-origin" value="'.htmlspecialchars(__('set as new uploader','arne_raetsel')).'" />';
    print '</form>';

    print '<form method="POST" action="">';
    print '<h3>'.htmlspecialchars(__('Delete Player','arne_raetsel')).'</h3>';
    print '<p>'.htmlspecialchars(__('Selected player will be removed from the highscore table.','arne_raetsel')).'</p>';
    if ((sizeof($optionen['userlist']) > 0) && (is_array($optionen['userlist']))) {
        print '<select id="user" name="user">';
        foreach ($optionen['userlist'] as $uid => $daten) {
            $cuser = get_userdata($uid);
            print '<option value="'.$uid.'">'.htmlspecialchars($cuser->display_name).'</option>';
        }
        print '</select>';
        
        print '<input type="submit" name="remove-player" value="'.htmlspecialchars(__('remove player','arne_raetsel')).'" />';
    } else {
        print '<p>'.htmlspecialchars(__('No players in highscore table...','arne_raetsel')).'</p>';
    }
    print '</form>';
    
    print '<form method="POST" action="">';
    print '<h3>'.htmlspecialchars(__('Start New Round','arne_raetsel')).'</h3>';
    print '<p>'.htmlspecialchars(__('Deletes logbook and highscores. After that any player can upload a new picture. (You can change the uploader after that if you want a specific player to start the new round.)','arne_raetsel')).'</p>';
    print '<input type="submit" name="start-new-round" value="'.htmlspecialchars(__('start new round','arne_raetsel')).'" />';
    print '</form>';
   
   
    print '<h2>'.htmlspecialchars(__('Main Settings','arne_raetsel')).'</h2>';
    
    
    print '<form method="POST" action="">';
    print '<h3>'.htmlspecialchars(__('Target Points','arne_raetsel')).'</h3>';
    print '<p>'.htmlspecialchars(__('When a player reaches at least this amount of points, he wins the game.','arne_raetsel')).' ('.htmlspecialchars(__('Default','arne_raetsel')).': <code>100</code>)</p>';
    print '<input type="number" name="points" value="'.$optionen['zielpunktzahl'].'" />';
    print '<input type="submit" name="set-target" value="'.htmlspecialchars(__('set as target points','arne_raetsel')).'" />';
    print '</form>';

    print '<form method="POST" action="">';
    print '<h3>'.htmlspecialchars(__('Keep Gallery Of Screenshots','arne_raetsel')).'</h3>';
    print '<p>'.htmlspecialchars(__('When a riddle is solved the screenshot is copied to a gallery path path.','arne_raetsel')).'</p>';
    print '<p><input type="checkbox" name="do-gallery" id="do-gallery" value="1"'.($optionen['dogallery'] ? ' checked="checked"' : '').' /> <label for="do-gallery">'.htmlspecialchars(__('keep screenshots','arne_raetsel')).'</label><br />';
    print '<input type="submit" name="set-gallery" value="'.htmlspecialchars(__('save gallery settings','arne_raetsel')).'" />';
    print '</form>';

    print '<form method="POST" action="">';
    print '<h3>'.htmlspecialchars(__('Program Execution','arne_raetsel')).'</h3>';
    print '<p>'.htmlspecialchars(__('Execute a program when a new entry to the logbook is added. The program gets the entry in BB-Code as a parameter.','arne_raetsel')).'</p>';
    print '<p>'.htmlspecialchars(__('Example','arne_raetsel')).': <code>sudo /opt/tssay</code> &rarr; <code>sudo /opt/tssay &quot;[b]'.htmlspecialchars(__('Guild Riddle','arne_raetsel')).':[/b] '.htmlspecialchars(__('Peter earns 10 points for the correct answer!','arne_raetsel')).'&quot;</code></p>';
    print '<p>('.htmlspecialchars(__('Leave field empty to execute no program.','arne_raetsel')).')</p>';
    print '<input type="text" name="programm" value="'.htmlspecialchars($optionen['programm']).'" />';
    print '<input type="submit" name="set-exec" value="'.htmlspecialchars(__('set program','arne_raetsel')).'" />';
    print '</form>';
}


/*
 *  DO I HAVE TO UNCOVER A NEW PART?
 */

function arne_raetsel_update_image() {
    $upload_dir = wp_upload_dir();
    $basedir = $upload_dir['basedir'];
    $baseurl = $upload_dir['baseurl'];
    
    $optionen = unserialize(get_option('arne_riddle'));

    if ($optionen['start'] == 0) {
        if (!file_exists($basedir.'/arne_riddle/riddle.jpg')) {
            copy(plugin_dir_path( __FILE__ ).'pic/default.jpg',$basedir.'/arne_riddle/riddle.jpg');
            @unlink($basedir.'/arne_riddle/riddle-klein.jpg');
        }
    } else {
        if (($optionen['solved'] == 0) && (time() >= $optionen['start'])) {
            $days = ceil( (time() - $optionen['start']) / (24 * 60 * 60) );
            if ($days != $optionen['last']) {
                $source = new Imagick();
                $source->readImage($basedir.'/arne_riddle/source/upload.jpg');

                $overlay = array();

                for ($i=$days;$i<=15;$i++) {
                    $overlay[$i] = new Imagick();
                    try {
                        $overlay[$i]->readImage(plugin_dir_path( __FILE__ ).'pic/'.$optionen['order'][$i].'.png');
                    } catch (Exception $e) {
                    
                    }
                    
                    try {
                        $source->compositeImage($overlay[$i], Imagick::COMPOSITE_DEFAULT, 0, 0);
                    } catch (Exception $e) {
                    
                    }
                }
                
                if ($days < 17) {
                    $overlay[0] = new Imagick();
                    $overlay[0]->readImage(plugin_dir_path( __FILE__ ).'pic/0.png');
                    $source->compositeImage($overlay[0], Imagick::COMPOSITE_DEFAULT, 0, 0);
                }

                $source->flattenImages();
                $source->writeImage($basedir.'/arne_riddle/riddle.jpg');
                @unlink($basedir.'/arne_riddle/riddle-klein.jpg');
                
                if ($optionen['origin'] != 0)  {
                    $optionen['last'] = $days;
                    update_option("arne_riddle", serialize($optionen));
                }
            }
        }
    }
}



/*
 *  AJAX
 */

function arne_raetsel_ajax() {
    global $region;
    $selected = stripslashes($_POST['zone']);
    $optionen = unserialize(get_option('arne_riddle'));
    
    if (!isset($region[$selected][1])) return;
    
    $zone = array();
    $zone[] = (__('Select Waypoint','arne_raetsel'));
    asort($region[$selected][1]);
    foreach ($region[$selected][1] as $waypoint) {
        $found = 0;
        if (!is_array($optionen['tipps'])) $optionen['tipps'] = array();
        foreach ($optionen['tipps'] as $tipp) {
            if (($tipp[0] == $selected) && ($tipp[1] == $waypoint)) $found = 1;
        }
        if (!$found) $zone[] = $waypoint;
    }
    
    print json_encode($zone);
    die();
}


function arne_raetsel_scripts() {
    wp_enqueue_script('arne_raetsel_script',plugins_url('arne_raetsel.js', __FILE__), array('jquery'));
    wp_localize_script( 'arne_raetsel_script', 'ajax_object',
    array( 'ajax_url' => admin_url( 'admin-ajax.php' )    ) );
}



/*
 *  DISPLAY RIDDLE IN THE FRONTEND INCLUDING MANAGMENT OF UPLOADS AND GUESSES
 */

function arne_raetsel_display( $attributes ) {
    $upload_dir = wp_upload_dir();
    $basedir = $upload_dir['basedir'];
    $baseurl = $upload_dir['baseurl'];
    include_once ABSPATH . 'wp-admin/includes/file.php';

    $galleryvalue = intval($_POST['arne_raetsel_to_gallery']);
    if ($galleryvalue == 1) $_SESSION['arne_raetsel_gallery'] = 'true';
    if ($galleryvalue == 2) $_SESSION['arne_raetsel_gallery'] = 'false';

    if ($_SESSION['arne_raetsel_gallery'] == 'true') {
        return arne_raetsel_gallery( $attributes );
    }

    global $region;
    $nothing = false;
    
    try {
        $optionen = unserialize(get_option('arne_riddle'));
    } catch (exception $e) {
        $nothing = true;
    }
    
    if (intval($optionen['zielpunktzahl']) == 0) $optionen['zielpunktzahl'] = 100;

    if (!is_array($optionen['logbuch'])) $optionen['logbuch'] = array();
    $ersteller = get_userdata( $optionen['origin'] );
    
    $ausgabe = '<h2>...'.htmlspecialchars($ersteller->display_name).'</h2>';

    $ich = get_current_user_id();

    arne_raetsel_update_image();
    
    
    // User allowed to guess? -> $aguess
    
    if ( isset( $_POST['arne-riddle-guess'] ) ) {
        $aguess = false;
        if ( ($ich != $optionen['origin']) && ($optionen['solved'] == 0) && (time() >= $optionen['start']) && (current_user_can('upload_files')) ) {
            if (is_array($optionen['userlist'])) {
                $meinedaten = $optionen['userlist'][$ich];
                if (is_array($meinedaten)) {
                    if (time() > $meinedaten[1] + (10*60*60)) {
                        $aguess = true;
                        $meinedaten[1] = time();
                    }
                } else {
                    $aguess = true;
                    $meinedaten = array(0,time());
                }
            } else {
                $aguess = true;
                $meinedaten = array(0,time());
            }
        }
        
        
        // User is allowed to guess: analysis of tipp

        if ($aguess && (($_POST["zone"] == "0") || ($_POST["waypoint"] == "0")) ) {
            $ausgabe .= '<span style="font-weight:bold;color:#c00;">'.htmlspecialchars(__('You didn\'t select a waypoint!','arne_raetsel')).'</span>';
            $aguess = false;
        }

        if ($aguess) { 
            $guessed_zone = stripslashes($_POST['zone']);
            if ( ((!is_array($optionen['solution'])) && (stripslashes($_POST['waypoint']) == $optionen['solution'])) || ((is_array($optionen['solution']) && (stripslashes($_POST['zone']) == $optionen['solution'][0]) && (stripslashes($_POST['waypoint']) == $optionen['solution'][1]))) ) {
                // guessed right. how many points?
                $days = floor((time() - $optionen['start']) / (24*60*60));
                $punkte = 17 - $days;
                if ($punkte < 1) $punkte = 1;
                $meinedaten[0]+=$punkte;
                $mich = get_userdata($ich);
                
                $points = sprintf( _n( '1 point', '%s points', $punkte, 'arne_raetsel'), $punkte );
                
                /* translators: leave '[USER]' and others untranslated, it will be replaced with actual values */
                $message = __('[USER] earns with the correct answer [ANSWER] [POINTS].','arne_raetsel');
                $message = str_replace('[USER]', $mich->display_name, $message);
                $message = str_replace('[ANSWER]', '»'.$guessed_zone.'«, »'.stripslashes($_POST['waypoint']).'«', $message);
                $message = str_replace('[POINTS]', $points, $message);
                $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
                if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
                if ($optionen['programm']) @exec($optionen['programm'].' "[b]'.htmlspecialchars(__('Guild Riddle','arne_raetsel')).':[/b] '.$message.'"');
                
                /* translators: leave '[POINTS]' untranslated, it will be replaced with actual values */
                $ausgabe .= '<p><strong>'.htmlspecialchars(str_replace('[POINTS]',$points,__('Yes, correct! You earned [POINTS] for this solution!','arne_raetsel'))).'</strong></p>';
                
                $optionen['solved'] = $ich;
                if ($meinedaten[0] >= $optionen['zielpunktzahl']) {
                    $optionen['solved'] = -1;
                    $optionen['origin'] = -1;

                    $mich = get_userdata($ich);
                    $message = sprintf(__('%s has won the game and asks for payment.','arne_raetsel'),$mich->display_name);

                    $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
                    if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
                } else {
                    $mich = get_userdata($ich);
                    $message = sprintf(__('%s is the next one to upload a new picture.','arne_raetsel'),$mich->display_name);

                    $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
                    if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
                }
                $optionen['last'] = 0;
                $optionen['tipps']    = array();
                
                copy($basedir.'/arne_riddle/source/upload.jpg',$basedir.'/arne_riddle/riddle.jpg');
                @unlink($basedir.'/arne_riddle/riddle-klein.jpg');
                
                if ($optionen['dogallery']) {
                    @copy($basedir.'/arne_riddle/source/upload.jpg',$basedir.'/arne_riddle/gallery/'.date('Y-m-d',time()+(get_option('gmt_offset')*3600)).'.jpg');
                }
                
            } else {
                // tipp is not matching solution. why?
                
                $myguess = array($guessed_zone, stripslashes($_POST['waypoint']));
                
                $legitimate = 0;
                
                if (sizeof($region[$myguess[0]]) > 0){
                    // zone exists
                    if (in_array($myguess[1], $region[$myguess[0]][1])) {
                        // waypoint exists
                        $legitimate = 1;
                        $found = 0;
                        foreach ($optionen['tipps'] as $tipp) {
                            if (($tipp[0] == $myguess[0]) && ($tipp[1] == $myguess[1])) $found = 1;
                        }
                        if ($found) {
                            $ausgabe .= '<p><span style="font-weight:bold;color:#c00;">'.htmlspecialchars(__('Meanwhile this waypoint has been guessed and it\'s not correct. You can try again now.','arne_raetsel')).'</span></p>';
                        } else {
                            // player is guessing a new and legitimate waypoint, but is of course wrong
                            $ausgabe .= '<p><strong>'.htmlspecialchars(__('Unfortunatley that\'s not correct!','arne_raetsel')).'</strong></p>';
                            $optionen['tipps'][] = $myguess;
                            $mich = get_userdata($ich);
                            
                            $message = sprintf(__('%s is guessing %s but that\'s not correct.','arne_raetsel'),$mich->display_name,'»'.htmlspecialchars($guessed_zone).'«, »'.htmlspecialchars(stripslashes($_POST['waypoint'])).'«');
                            $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
                            if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
                            if ($optionen['programm']) @exec($optionen['programm'].' "[b]'.htmlspecialchars(__('Guild Riddle','arne_raetsel')).':[/b] '.$message.'"');
                        }
                    }
                }
                
                if (!$legitimate) {
                    $ausgabe .= '<p><span style="font-weight:bold;color:#c00;">'.htmlspecialchars(__('That\'s not a legitimate waypoint.','arne_raetsel')).'</span></p>';
                }
                
            }
            $optionen['userlist'][$ich] = $meinedaten;
            update_option("arne_riddle", serialize($optionen));
        }
    
    }
    
    
    // User uploaded new picture

    if ( isset( $_POST['riddle-upload'] ) ) {
        // Only JPG and PNG. Not even annoying GIFs.
        
        if (($ich == $optionen['solved']) || ($optionen['start'] == 0) || ( ($optionen['origin'] == $ich) && ($optionen['solved'] == 0) && (time() < $optionen['start']) )  && ($_POST["zone"] != "0") && ($_POST["waypoint"] != "0") ) {
            if ( ! empty( $_FILES['picture']['name'] ) ) {
                $mimes = array(
                        'jpg|jpeg' => 'image/jpeg',
                        'png' => 'image/png'
                );
                $riddlefile = wp_handle_upload( $_FILES['picture'], array( 'mimes' => $mimes, 'test_form' => false ) );
                if ( ! empty ( $riddlefile['file'] ) ) {
                    $picture_file = $riddlefile['file'];
                    rename ($picture_file,$basedir.'/arne_riddle/source/upload.jpg');
                    $image = wp_get_image_editor($basedir.'/arne_riddle/source/upload.jpg');
                    if ( ! is_wp_error( $image ) ) {
                        $image->resize(1024,768,true);
                        $image->save($basedir.'/arne_riddle/source/upload.jpg');
                        
                        // check whether too small
                        $image = new Imagick($basedir.'/arne_riddle/source/upload.jpg');
                        $d = $image->getImageGeometry();
                        $w = $d['width'];
                        $h = $d['height']; 
                        if (($w != 1024) || ($h != 768)) {
                            
                            $nw = 1024;
                            $nh = intval((1024 / $w) * $h);
                            
                            if ($nh < 768) {
                                $nh = 768;
                                $nw = intval((768 / $h) * $w);
                            }
                        
                            $image->resizeImage($nw,$nh,Imagick::FILTER_LANCZOS,1);
                            $x = 0;
                            $y = 0;
                            if ($nw > 1024) $x = intval(($nw - 1024) / 2);
                            if ($nh > 768) $y = intval(($nh - 768) / 2);
                            $image->cropImage(1024,768,$x,$y);
                            $image->writeImage($basedir.'/arne_riddle/source/upload.jpg');
                        }
                        
                        $optionen['order'] = array();
                        for ($i=1;$i<=16;$i++) $optionen['order'][]=$i;
                        for ($i=1;$i<=100;$i++) {
                            $optionen['order'] = array_merge(array_splice($optionen['order'],rand(0,15),1),$optionen['order']);
                        }
                        
                        // Time: 0600 localtime
                        $optionen['start'] = mktime(6,0,0,date('n',time()+(get_option('gmt_offset')*3600)),date('j',time()+(get_option('gmt_offset')*3600)),date('y',time()+(get_option('gmt_offset')*3600)));
                        if (date('H',time()+(get_option('gmt_offset')*3600)) >= 6) $optionen['start'] += (24*60*60);

                        // pendant in UTC
                        $optionen['start'] -= get_option('gmt_offset')*3600;
                        
                        $optionen['origin']   = get_current_user_id();
                        $optionen['solution'] = array(stripslashes($_POST['zone']),stripslashes($_POST['waypoint']));
                        $optionen['last']     = 0;
                        $optionen['solved']   = 0;
                        $optionen['tipps']    = array();
                        
                        $mich = get_userdata($ich);
                        
                        $message = sprintf(__('%s uploaded a new picture. New round starts tomorrow.','arne_raetsel'),$mich->display_name);
                        $optionen['logbuch'][] = '<li>['.date('Y-m-d H:i',time()+(get_option('gmt_offset')*3600)).'] '.htmlspecialchars($message).'</li>';
                        if (sizeof($optionen['logbuch']) > 5) array_shift($optionen['logbuch']);
                        update_option("arne_riddle", serialize($optionen));
                        if ($optionen['programm']) @exec($optionen['programm'].' "[b]'.htmlspecialchars(__('Guild Riddle','arne_raetsel')).':[/b] '.$message.'"');
                    }
                    unset($image);
                }
            } 
        }
        if (($_POST["zone"] == "0") || ($_POST["waypoint"] == "0")) {
            $ausgabe .= '<span style="font-weight:bold;color:#c00;">'.htmlspecialchars(__('You didn\'t select a waypoint!','arne_raetsel')).'</span>';
        }
    }
    
    ksort($region);
    
    // create clickable preview picture
    
    if (!file_exists($basedir.'/arne_riddle/riddle-klein.jpg')) {
        $image = wp_get_image_editor($basedir.'/arne_riddle/riddle.jpg');
        if ( ! is_wp_error( $image ) ) {
            $image->resize(400,300,true);
            $image->save($basedir.'/arne_riddle/riddle-klein.jpg');
        }
    }
    $datum = date('Ymd',time()+(get_option('gmt_offset')*3600)).($optionen['solved'] ? '-solved' : '');
    if (date('H',time()+(get_option('gmt_offset')*3600)) < 6) {
        $datum = date('Ymd', time() - (7*60*60) + (get_option('gmt_offset')*3600)).($optionen['solved'] ? '-solved' : '');
    }
    $ausgabe .= '<a href="'.$baseurl.'/arne_riddle/riddle.jpg?'.$datum.'"><img src="' . $baseurl.'/arne_riddle/riddle-klein.jpg?'.$datum . '" alt="aktuelles Rätsel" /></a>';
    
    
    // display hint (after some time)
    
    $vierzehn = ((time() - $optionen['start']) >  ( 15 * 24 * 60 * 60 ) ? true : false );
    $sieben = ((time() - $optionen['start']) >  ( 7 * 24 * 60 * 60 ) ? true : false);
    if ($optionen['start'] == 0) $vierzehn = false;
    if ( $sieben && ($optionen['solved'] == 0)  && ($optionen['start'] != 0)) {
        $ausgabe .= '<h2>'.htmlspecialchars(__('Hint','arne_raetsel')).' '.($vierzehn ? '2' : '1').'</h2><ul>';
        $rzone = "";
        $rregion = "";
        // compatibility -- can be reduced if old version is extinguished
        if (is_array($optionen['solution'])) {
            $rzone  = $optionen['solution'][0];
            $rregion = $region[$rzone][0];
        } else {
            foreach ($region as $zz => $ra) {
                if (in_array($optionen['solution'],$ra[1])) {
                    $rzone = $zz;
                    $rregion = $ra[0];
                    break;
                }
            }
        }
        if ($vierzehn) {
            $message = sprintf(__('The screenshot was taken in %s.','arne_raetsel'),'»'.$rzone.'«');
            $ausgabe .= '<li>'.htmlspecialchars($message).'</li>';
        } else {
            $rregionex = array();
            foreach ($region as $zz => $ra) {
                if ($ra[0] == $rregion) $rregionex[] = $zz;
            }
            $message = sprintf(__('The screenshot was taken in the region %s.','arne_raetsel'),'»'.$rregion.'« ('.implode(', ',$rregionex).')');
            $ausgabe .= '<li>'.htmlspecialchars($message).'</li>';
        }
        $ausgabe .= '</ul>';
    }


    /*
     *  fill in zone automatically as soon as hint reveals right one
     *  and remove zones that don't fit the hint or are empty
     *  (all waypoints have already been guessed)
     */
    
    $zone = '<select onchange="wp_set();" name="zone" id="zone">';
    $zone .= '<option value="0">'.htmlspecialchars(__('Select Zone','arne_raetsel')).'</option>';
    if (!is_array($optionen['tipps'])) $optionen['tipps'] = array();
    foreach ($region as $key => $value) {
        if (($sieben) && ($value[0] != $rregion) && ($optionen['solved'] == 0)) continue;
        if (($vierzehn) && ($key != $rzone) && ($optionen['solved'] == 0)) continue;
        $tzone = array();
        foreach ($optionen['tipps'] as $tipp) {
            if ($tipp[0] == $key) {
                $tzone[] = $tipp[1];
            }
        }
        if (sizeof(array_diff($value[1],$tzone)) == 0) continue;
        $zone .= '<option value="'.htmlspecialchars($key).'"'.(($vierzehn && ($key == $rzone)) ? ' selected="selected"' : '').'>'.htmlspecialchars($key).'</option>';
    }
    $zone.='</select>';
    $zone .= '<select name="waypoint" id="waypoint"></select>';


    // display game elements (upload, waypoints or hints)

    if (!current_user_can('upload_files')) {
        $ausgabe .= '<p>'.htmlspecialchars(__('To participate in this game, you have to be registered to this site and the administrator must have given you the right to upload files.','arne_raetsel')).'</p>';
    } else {
        
        $upload = '<div><span style="font-size: 20pt;">1. </span><label for="picture">'.htmlspecialchars(__('Screenshot','arne_raetsel')).':</label>
<input type="file" name="picture" id="picture" /><br />
<span style="font-size: 20pt;">2. </span>'.htmlspecialchars(__('Which waypoint is the nearest to your picture','arne_raetsel')).':<br />'.$zone.'</div>

<p><span style="font-size: 20pt;">3. </span><input type="submit" name="riddle-upload" value="'.htmlspecialchars(__('Upload picture','arne_raetsel')).'" /></p>' . "\n";
        
        $ausgabe .= '<form method="post" enctype="multipart/form-data" action="">'."\n";
        
        $raten = $zone . '<p><input type="submit" name="arne-riddle-guess" value="'.htmlspecialchars(__('submit guess','arne_raetsel')).'" /></p>';
        
        if ($nothing || ($optionen['start'] == 0)) {
            $ausgabe .= '<p>'.htmlspecialchars(__('Never played before. Please upload a picture.','arne_raetsel')).'</p>';
            $ausgabe .= $upload;
        } else {
            if ($optionen['solved']) {
                if ($optionen['solved'] == $ich) {
                    $ausgabe .= '<p>'.htmlspecialchars(__('You have solved the riddle and now you have to upload a picture for the next round.','arne_raetsel')).'</p>';
                    $ausgabe .= $upload;
                } else {
                    if ($optionen['solved'] == -1) {
                        $ausgabe .= '<p>'.htmlspecialchars(__('The game is over. Now everybody has to pay the winner, then the administrator can start a new round.','arne_raetsel')).'</p>';
                    } else {
                        $solver = get_userdata( $optionen['solved'] );
                        $message = sprintf(__('%s has solved the ridde and has to upload a picture for the next round now.','arne_raetsel'),$solver->display_name);
                        $ausgabe .= '<p>'.htmlspecialchars($message).'</p>';
                    }
                }
            } else {
                if (time() >= $optionen['start']) {
                    if ($ich == $optionen['origin']) {
                        $ausgabe .= '<p>'.htmlspecialchars(__('You created this riddle and cannot participate in this round.','arne_raetsel')).'</p>';
                    } else {
                        $optionen['last'] = $optionen['userlist'][$ich][1];
                        if (!isset($optionen['last']) || (time() >= $optionen['last'] + (10*60*60)) ){
                            $ausgabe .= '<p>'.htmlspecialchars(__('Select the waypoint nearest to this place.','arne_raetsel')).'</p>';
                            $ausgabe .= $raten;
                        } else {
                            $minutes = ceil((($optionen['last']+(10*60*60)) - time()) / 60);
                            if ($minutes >= 60) {
                                $hours = floor($minutes / 60);
                                $minutes -= ($hours * 60);
                            } else {
                                $hours = 0;
                            }
                            $zeitstring = $minutes . '  ' . ($minutes == 1 ? __('minute','arne_raetsel') : __('minutes','arne_raetsel'));
                            if ($hours > 0) {
                                $zeitstring = $hours . '  ' . ($hours == 1 ? __('hour','arne_raetsel') : __('hours','arne_raetsel')) . ', ' . $zeitstring;
                            }
                            $message = sprintf(__('You already made a guess and have to wait %s before the next guess.','arne_raetsel'),$zeitstring);
                            $ausgabe .= '<p>'.htmlspecialchars($message).'</p>';
                        }
                    }
                } else {
                    if ($ich == $optionen['origin']) {
                        $ausgabe .= '<p>'.htmlspecialchars(__('You already uploaded a new picture, but because the new round hasn\'t started yet, you can upload another one.','arne_raetsel')).'</p>';
                        $ausgabe .= $upload;
                    } else {
                        $ausgabe .= '<p>'.htmlspecialchars(__('A new picutre has been uploaded an the new round starts tomorrow.','arne_raetsel')).'</p>';
                    }
                }
            }
        }
        
        $ausgabe .= '</form>'."\n";
        
        
    }
    
    
    // Logbook: display last 5 actions
    
    if (sizeof($optionen['logbuch'])>0) {
        $ausgabe .= '<h2>'.htmlspecialchars(__('Logbook','arne_raetsel')).'</h2><ul class="logbuch">';
        $temp = "";
        foreach ($optionen['logbuch'] as $zeile) {
            $temp = $zeile . $temp;
        }
        $ausgabe .= $temp;
        $ausgabe .= '</ul>';
    }
    
    
    // display highscores (and this way all players who ever participated in this round)
    
    if (is_array($optionen['userlist'])) {
        $ausgabe .= '<h2>'.htmlspecialchars(__('Highscores','arne_raetsel')).'</h2><ul>';
        $highscores = array();
        foreach ($optionen['userlist'] as $id => $punkte) {
            if (isset($highscores[$punkte[0]])) {
                $list = $highscores[$punkte[0]];
            } else {
                $list = array();
            }
            $dertyp = get_userdata( $id );
            $list[] = $dertyp->display_name;
            $highscores[$punkte[0]] = $list;
        }
        
        krsort($highscores);
        foreach ($highscores as $punkte => $liste) {
            asort($liste);
            foreach ($liste as $player) {
                $ausgabe .= '<li>'.$punkte.': <em>'.htmlspecialchars($player).'</em></li>';
            }
        }
        $ausgabe.='</ul>';
    }
    
    
    // display gallery
    
    if ($optionen['dogallery']) {
        $pics = glob( $basedir.'/arne_riddle/gallery/*.jpg' );
        if (sizeof($pics) > 0) {
            $ausgabe .= '<form action="" name="arne_to_the_gallery" method="POST"><a href="javascript:document.arne_to_the_gallery.submit();" onclick="">'.htmlspecialchars(__('Show gallery of prior images','arne_raetsel')).'</a><input type="hidden" name="arne_raetsel_to_gallery" value="1" /></form>';
        }
    }
    return $ausgabe;
}

function arne_raetsel_gallery( $attributes ) {
    $upload_dir = wp_upload_dir();
    $basedir = $upload_dir['basedir'];
    $baseurl = $upload_dir['baseurl'];

    $ausgabe = '<h1>'.htmlspecialchars(__('Gallery','arne_raetsel')).'</h1>';
    
    $ausgabe .= '<form action="" name="arne_to_the_gallery" method="POST"><a href="javascript:document.arne_to_the_gallery.submit();" onclick="">'.htmlspecialchars(__('Back to the riddle','arne_raetsel')).'</a><input type="hidden" name="arne_raetsel_to_gallery" value="2" /></form>';
    
    $pics = glob( $basedir.'/arne_riddle/gallery/*.jpg' );
    arsort($pics);
    
    $ausgabe .= "\n".'<div class="arne_raetsel_gallery">'."\n";
    
    foreach ($pics as $pic) {
        $datei = basename($pic);
        if (!file_exists($basedir.'/arne_riddle/gallery/thumbs/'.$datei)) {
            $image = wp_get_image_editor($basedir.'/arne_riddle/gallery/'.$datei);
            if ( ! is_wp_error( $image ) ) {
                $image->resize(148,111,true);
                $image->save($basedir.'/arne_riddle/gallery/thumbs/'.$datei);
            }
            unset($image);
        }
        $url = $baseurl.'/arne_riddle/gallery/thumbs/'.$datei;
        $purl = $baseurl.'/arne_riddle/gallery/'.$datei;
        $alt = substr($datei,0,strlen($datei)-4);
        $ausgabe .= '<a href="'.$purl.'"><img width="148" height="111" src="'.$url.'" class="alignnone" alt="'.$alt.'" title="'.$alt.'" /></a>';
    }
    $ausgabe .= '</div>';
    $ausgabe .= '<form action="" name="arne_to_the_gallery2" method="POST"><a href="javascript:document.arne_to_the_gallery2.submit();" onclick="">'.htmlspecialchars(__('Back to the riddle','arne_raetsel')).'</a><input type="hidden" name="arne_raetsel_to_gallery" value="2" /></form>';
    return $ausgabe;
}

function arne_raetsel_explain() {
    $optionen = unserialize(get_option('arne_riddle'));
    if (intval($optionen['zielpunktzahl']) == 0) $optionen['zielpunktzahl'] = 100;
    return '<h1>'.htmlspecialchars(__('Game','arne_raetsel')).'</h1>
<p>'.htmlspecialchars(__('The game works as follows: one player uploads a screenshot. This will be displayed only covered. Every day one part will be removed so you can see every day more of the screenshot.','arne_raetsel')).'</p>
<p>'.htmlspecialchars(__('The other players have to guess where the screenshot was taken by selecting the nearest waypoint. Once a player guessed right he earns points, the more points the more parts are still covered. So a player can earn between 1 and 17 points. A player can guess every 10 hours at most.','arne_raetsel')).'</p>
<p>'.htmlspecialchars(__('The player who guessed right has to upload the picture for the next round.','arne_raetsel')).'</p>
<p>'.htmlspecialchars(sprintf(__('The player who reaches %d points first, wins the game.','arne_raetsel'),$optionen['zielpunktzahl'])).'</p>
<h1>'.htmlspecialchars(__('Winnings','arne_raetsel')).'</h1>
<p>'.htmlspecialchars(sprintf(__('Every player who ever guessed counts as participant of the game, even if he never guessed right. When a player reached at least %d points every participant has to pay the winner the amount of one gold. So the winnings are the higher the more players take part.','arne_raetsel'),$optionen['zielpunktzahl'])).'</p>
<h1>'.htmlspecialchars(__('Take Part','arne_raetsel')).'</h1>
<p>'.htmlspecialchars(__('You have to be registered to this site and the administrator must give you the right to upload files.','arne_raetsel')).'</p>
<h1>'.htmlspecialchars(__('Rules For Screenshots','arne_raetsel')).'</h1>
<p>'.htmlspecialchars(__('It\'s only allowed to take screenshots in not instanciated regions, so not in dungeons or in the personal story quest and things like that. And of course a player has to be able to solve the riddle when he sees the whole screenshot. So just don\'t make close-ups of daisies or the sky but include enough of the environment so that the players get enough hints for the correct solution.','arne_raetsel')).'</p>
<h1>'.htmlspecialchars(__('Screenshots','arne_raetsel')).'</h1>
<p>'.htmlspecialchars(__('If you have won a round you have to upload your own screenshot. To do so, press [Ctrl] + [Shift] + [H] in the game to fade out the interface. This is important so that nobody can see your minimap and other hints. After that press [prtscr] (over [ins]) and the screenshot is done. You can find it in your home directory in the subfolder Documents\GUILD WARS 2\Screens. (e. g. C:\Users\Arne\Documents\GUILD WARS 2\Screens) Please do not resize or convert the images to another format before the upload. Don\'t forget to select the nearest waypoint, so the winner can be determined automatically.','arne_raetsel')).'</p>';
}
?>