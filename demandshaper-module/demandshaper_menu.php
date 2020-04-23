<?php

global $mysqli,$redis,$session;

if ($session['write']) {

    $menu['tabs'][] = array(
        'icon'=>'calendar',
        'text'=> _("DemandShaper"),
        'path'=> 'demandshaper',
        'data'=> array('sidebar' => '#sidebar_demandshaper')
    );

    require_once "Modules/demandshaper/demandshaper_model.php";
    $demandshaper = new DemandShaper($mysqli,$redis);

    require_once "Modules/device/device_model.php";
    $device = new Device($mysqli,$redis);

    $devices = $demandshaper->get_list($device,$session['userid']);
    
    $o=0;
    foreach ($devices as $name=>$d) {
        $menu['sidebar']['demandshaper'][] = array(
            'icon' => $d["type"],
            'text' => ucfirst($devices[$name]['custom_name']),
            'path' => "demandshaper?device=".$name,
            'order'=> $o
        );
        $o++;
    }
    
    $menu['sidebar']['demandshaper'][] = array(
        'icon' => "plus",
        'text' => "Add Device",
        'path' => "demandshaper#add",
        'id'=> "add-device",
        'order'=> $o
    );
}
// these <symbols> will be included into the theme.php file within the <svg><defs> 
$menu['includes']['icons'][] = <<<ICONS
        <symbol id="icon-smartplug" viewBox="0 0 32 32">
            <!-- <title>smart_plug</title> -->
            <path d="m 23.25899,0.51693219 c -0.291893,0.0200725 -0.585576,0.15239844 -0.813057,0.39192845 L 16.872602,6.7772337 18.460181,8.2846985 24.032899,2.4163279 C 24.48786,1.9372548 24.500397,1.2150987 24.060905,0.79767932 23.841129,0.58896847 23.550919,0.49686208 23.259038,0.51693219 Z M 14.269469,5.3852976 c -0.354965,0.015854 -0.703952,0.163746 -0.969575,0.4434823 -0.547207,0.5762169 -0.524044,1.4813777 0.05218,2.0285856 L 25.247205,19.153734 c 0.576226,0.547209 1.481376,0.524045 2.028586,-0.05218 0.531248,-0.55941 0.519397,-1.425493 -0.0084,-1.976413 L 15.274103,5.735611 C 14.985381,5.4861313 14.624713,5.3694451 14.269748,5.3852976 Z m 16.673435,2.4292125 c -0.291893,0.020072 -0.585577,0.1517723 -0.813057,0.3913082 l -5.572718,5.8689897 1.586978,1.507467 5.573331,-5.8689918 C 32.172387,9.2342088 32.184322,8.5126778 31.744722,8.0952573 31.524946,7.8865464 31.234736,7.7944364 30.942855,7.8145101 Z M 12.907967,7.9306543 6.9458115,14.218904 c -2.2690183,2.80115 -2.519563,6.603017 -0.8614966,9.565296 l -3.4534467,3.636677 c -0.7474402,0.787069 -0.7156476,2.022144 0.071432,2.769591 l 0.5937953,0.564601 c 0.7870709,0.747443 2.0221493,0.715022 2.7695895,-0.07206 l 3.411826,-3.592576 c 3.075639,1.619865 6.963796,1.207364 9.701314,-1.254668 l 6.018064,-6.234834 -3.908731,-3.711834 -4.527986,-4.300035 z m -0.980752,6.7168267 2.714306,0.35528 1.791313,4.316806 -2.008084,-0.262734 0.764604,4.634822 -3.537919,-6.141667 2.073929,0.272053 z"></path>
        </symbol>
        
        <symbol id="icon-wifirelay" viewBox="0 0 32 32">
            <!-- <title>wifi_relay</title> -->
            <path d="m 23.25899,0.51693219 c -0.291893,0.0200725 -0.585576,0.15239844 -0.813057,0.39192845 L 16.872602,6.7772337 18.460181,8.2846985 24.032899,2.4163279 C 24.48786,1.9372548 24.500397,1.2150987 24.060905,0.79767932 23.841129,0.58896847 23.550919,0.49686208 23.259038,0.51693219 Z M 14.269469,5.3852976 c -0.354965,0.015854 -0.703952,0.163746 -0.969575,0.4434823 -0.547207,0.5762169 -0.524044,1.4813777 0.05218,2.0285856 L 25.247205,19.153734 c 0.576226,0.547209 1.481376,0.524045 2.028586,-0.05218 0.531248,-0.55941 0.519397,-1.425493 -0.0084,-1.976413 L 15.274103,5.735611 C 14.985381,5.4861313 14.624713,5.3694451 14.269748,5.3852976 Z m 16.673435,2.4292125 c -0.291893,0.020072 -0.585577,0.1517723 -0.813057,0.3913082 l -5.572718,5.8689897 1.586978,1.507467 5.573331,-5.8689918 C 32.172387,9.2342088 32.184322,8.5126778 31.744722,8.0952573 31.524946,7.8865464 31.234736,7.7944364 30.942855,7.8145101 Z M 12.907967,7.9306543 6.9458115,14.218904 c -2.2690183,2.80115 -2.519563,6.603017 -0.8614966,9.565296 l -3.4534467,3.636677 c -0.7474402,0.787069 -0.7156476,2.022144 0.071432,2.769591 l 0.5937953,0.564601 c 0.7870709,0.747443 2.0221493,0.715022 2.7695895,-0.07206 l 3.411826,-3.592576 c 3.075639,1.619865 6.963796,1.207364 9.701314,-1.254668 l 6.018064,-6.234834 -3.908731,-3.711834 -4.527986,-4.300035 z m -0.980752,6.7168267 2.714306,0.35528 1.791313,4.316806 -2.008084,-0.262734 0.764604,4.634822 -3.537919,-6.141667 2.073929,0.272053 z"></path>
        </symbol>

        <symbol id="icon-openevse" viewBox="0 0 32 32">
            <!-- <title>openevse</title> -->
            <path d="m 4.271181,3.8763201 c -0.66746,0 -1.20458,0.53712 -1.20458,1.20458 V 28.83242 H 2 v 2.788462 H 19.041338 V 28.83242 h -1.02474 V 15.78309 c 0.37684,-0.0501 0.92994,-0.0941 1.49861,-0.007 0.47878,0.0736 0.91777,0.23495 1.23403,0.50178 0.31314,0.26419 0.55329,0.63335 0.64493,1.33997 l 0.0935,6.84557 0.002,0.0295 c 0.13205,1.63745 0.7532,2.78098 1.63297,3.414261 0.87978,0.633279 1.88516,0.729829 2.68925,0.7028 0.80883,-0.0272 1.83568,-0.20604 2.681481,-0.95084 0.845809,-0.7448 1.391499,-1.991401 1.443329,-3.77962 v -0.0176 L 29.821469,13.209329 a 3.0979756,3.0979756 0 0 0 2.164731,-2.95331 3.0979756,3.0979756 0 0 0 -0.008,-0.15192 h 0.006 V 7.38178 H 31.051454 V 4.3085801 H 30.008625 V 7.38178 H 27.760668 V 4.3085801 h -1.04283 V 7.38178 h -0.93482 v 2.72232 h 0.0139 a 3.0979756,3.0979756 0 0 0 -0.007,0.15192 3.0979756,3.0979756 0 0 0 2.265499,2.98432 l 0.115752,10.60193 c -0.0453,1.45931 -0.43047,2.12833 -0.84388,2.49236 -0.41509,0.36553 -0.97729,0.49156 -1.57406,0.5116 -0.601521,0.0202 -1.18334,-0.0711 -1.5999,-0.37104 -0.4157,-0.29923 -0.797151,-0.83324 -0.902271,-2.11925 l -0.0956,-6.8926 -0.006,-0.0486 c -0.13493,-1.08653 -0.61636,-1.94018 -1.26349,-2.48615 -0.64713,-0.54596 -1.40969,-0.79003 -2.10323,-0.89659 -0.66306,-0.10188 -1.28895,-0.0808 -1.7663,-0.032 V 5.0806501 c 0,-0.66746 -0.53764,-1.20458 -1.2051,-1.20458 z m 0.5947931,2.17145 H 16.038418 V 13.93204 H 4.8659741 Z M 28.884667,8.82072 a 1.3614041,1.3614041 0 0 1 1.361152,1.36116 1.3614041,1.3614041 0 0 1 -1.361152,1.36167 1.3614041,1.3614041 0 0 1 -1.361159,-1.36167 1.3614041,1.3614041 0 0 1 1.361159,-1.36116 z m -19.01848,8.13284 h 3.595641 l -2.88406,3.82716 h 2.74712 L 7.670455,28.17458 9.456392,22.269 H 6.7971231 Z"></path>
        </symbol>

        <symbol id="icon-emonth" viewBox="0 0 32 32">
            <!-- <title>emonth</title> -->
            <path d="m 13.679206,0.29798677 c -3.225442,0 -5.8551056,2.63217853 -5.8551056,5.85575643 v 9.9098388 c -1.9522162,1.706206 -3.3706827,3.989186 -3.3730942,6.705857 v 0.0025 0.0025 c 5.03e-5,5.060831 4.1653869,9.22551 9.2262488,9.225561 5.060847,-5.1e-5 9.222933,-4.16473 9.222997,-9.22559 -8.69e-4,-2.715488 -1.415623,-5.001816 -3.365289,-6.709117 v -2.49437 H 22.09633 V 10.757915 H 19.534963 V 9.5975587 H 22.09633 V 6.7844753 H 19.534963 V 6.153567 c 0,-3.224396 -2.631373,-5.85510193 -5.855757,-5.85510193 z M 13.678541,2.918548 v 6.419e-4 c 1.760328,0 3.235208,1.4748925 3.235208,3.2352078 V 17.04442 c 2.036046,1.153585 3.365817,3.321815 3.366584,5.730231 v 6.32e-4 c -2.6e-5,3.624956 -2.978785,6.603715 -6.603732,6.603753 -3.624958,-3.8e-5 -6.6037032,-2.978797 -6.6037396,-6.603744 v -0.0025 C 7.0750414,20.36367 8.4064253,18.196033 10.444,17.043869 V 6.1538187 c 0,-1.759258 1.474233,-3.2351952 3.234552,-3.2351952 z M 12.310066,6.8692072 V 18.242498 c -1.999879,0.602461 -3.3692896,2.443494 -3.3711426,4.532152 2.6e-5,2.616534 2.1211426,4.737652 4.7376776,4.737677 2.616534,-2.5e-5 4.737652,-2.121143 4.737678,-4.737677 -6.68e-4,-2.08789 -1.368047,-3.929199 -3.366586,-4.53345 V 6.8692072 Z"></path>
        </symbol>

        <symbol id="icon-hpmon" viewBox="0 0 32 32">
            <!-- <title>heatpumpmonitor</title> -->
            <path d="M 5.5201055,4.4518919 C 3.569967,4.4518919 2,6.0218531 2,7.9719965 V 24.027991 c 0,1.950144 1.569967,3.520117 3.5201055,3.520117 H 28.580503 c 1.950144,0 3.520105,-1.569973 3.520105,-3.520117 V 7.9719965 c 0,-1.9501434 -1.569961,-3.5201046 -3.520105,-3.5201046 z M 13.545873,7.9828628 A 8.1040157,8.1040157 0 0 1 21.649662,16.086652 8.1040157,8.1040157 0 0 1 13.545873,24.19044 8.1040157,8.1040157 0 0 1 5.4420802,16.086652 8.1040157,8.1040157 0 0 1 13.545873,7.9828628 Z m -0.04728,1.7447119 v 6.222e-4 c -2.776917,-0.02896 -2.244732,2.8981181 -1.354579,5.2859181 0.04851,0.35048 -0.09752,0.497199 -0.330653,0.53658 -2.4689858,0.500466 -5.2021235,1.595171 -3.7797624,3.972278 1.3981991,2.336749 3.5592944,0.475368 5.1241064,-1.489528 0.278154,-0.308488 0.486419,-0.301743 0.699029,0.0025 1.600456,1.904412 3.804718,3.693544 5.204693,1.358416 1.419171,-2.367083 -1.332723,-3.388857 -3.830931,-3.831575 -0.350814,-0.06138 -0.448535,-0.207326 -0.321693,-0.530825 0.864362,-2.367912 1.362191,-5.275596 -1.41021,-5.304457 z m 13.423596,4.6226943 a 1.7365748,1.7365748 0 0 1 1.737027,1.736383 1.7365748,1.7365748 0 0 1 -1.737027,1.736395 1.7365748,1.7365748 0 0 1 -1.736383,-1.736395 1.7365748,1.7365748 0 0 1 1.736383,-1.736383 z"></path>
        </symbol>
        <symbol id="icon-smartmeter" viewBox="0 0 32 32">
            <!-- <title>smartmeter</title> -->
            <path d="M4.688 24.625l-2-2 10-10 5.313 5.375 9.438-10.625 1.875 1.875-11.313 12.75-5.313-5.375z"></path>
        </symbol>
        <symbol id="icon-edmi-am" viewBox="0 0 32 32">
            <!-- <title>smartmeter</title> -->
            <path d="M4.688 24.625l-2-2 10-10 5.313 5.375 9.438-10.625 1.875 1.875-11.313 12.75-5.313-5.375z"></path>
        </symbol>
        
ICONS;
