<div id="navBarContainer">
    <nav class="navBar">

        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo" >
            <img src="assets/images/icons/podcastLogo.png" alt="Logo">
        </span>

        <div class="group">
            <div class="navItem">
                <span role='link' tabindex='0' onclick='openPage("search.php")' class="navItemLink">
                    Search
                    <img src="assets/images/icons/search.png" class="icon" alt="Search Icon">
                </span>
            </div>
        </div>

        <div class="group">

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')"  class="navItemLink">Browse</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Your Podcasts</span> 
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('settings.php')"  class="navItemLinktext"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
            </div> 

        </div>

    </nav>               
</div>