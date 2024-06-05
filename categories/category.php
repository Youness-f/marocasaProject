<?php require '../includes/header.php'; ?>
<?php require '../config/config.php'; ?>

<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch all properties for the slider
$select = $conn->query("SELECT * FROM props ORDER BY name DESC");
$select->execute();
$props = $select->fetchAll(PDO::FETCH_OBJ);

// Initialize variable to hold listings
$alllistings = [];

// Check for 'type' parameter
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $stmt = $conn->prepare("SELECT * FROM props WHERE home_type = :type");
    $stmt->execute(['type' => $type]);
    $alllistings = $stmt->fetchAll(PDO::FETCH_OBJ);
    // if (empty($alllistings)) {
    //     echo "<div class='bg-warning p-3 text-center'>No properties found for type: " . htmlspecialchars($type) . "</div>";
    // }
}

// Check for 'price' parameter
if (isset($_GET['price'])) {
    $price = $_GET['price'];
    $stmt = $conn->query("SELECT * FROM props ORDER BY price $price");
    $alllistings = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (empty($alllistings)) {
        echo "<div class='bg-warning p-3 text-center'>No properties found for price order: " . htmlspecialchars($price) . "</div>";
    }
}

// Check for 'name' parameter
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    if (empty($name)) {
        echo "<div class='bg-warning p-3 text-center'>No home type specified.</div>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM props WHERE home_type = :name");
        $stmt->execute(['name' => $name]);
        $alllistings = $stmt->fetchAll(PDO::FETCH_OBJ);
        // if (empty($alllistings)) {
        //     echo "<div class='bg-warning p-3 text-center'>No properties found for home type: " . htmlspecialchars($name) . "</div>";
        // }
    }
} else {
    echo "<div class='bg-warning p-3 text-center'>No home type specified.</div>";
}
?>


<div class="slide-one-item home-slider owl-carousel">
    <?php foreach ($props as $prop) : ?>
        <div class="site-blocks-cover overlay" style="background-image: url(<?php echo THUMBNAILSURL; ?>/<?php echo $prop->image; ?>);" data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-10">
                        <span class="d-inline-block bg-<?php echo $prop->type == "rent" ? "success" : "danger"; ?> text-white px-3 mb-3 property-offer-type rounded"><?php echo $prop->type; ?></span>
                        <h1 class="mb-2"><?php echo $prop->name; ?></h1>
                        <p class="mb-5"><strong class="h2 text-success font-weight-bold">$<?php echo $prop->price; ?></strong></p>
                        <p><a href="property-details.php?id=<?php echo $prop->id; ?>" class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">See Details</a></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<div class="site-section site-section-sm pb-0">
    <div class="container">
        <div class="row">
            <form class="form-search col-md-12" method="GET" action="category.php" style="margin-top: -100px;">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label for="list-types">Listing Types</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="type" id="list-types" class="form-control d-block rounded-0">
                                <option value="condo">Condo</option>
                                <option value="commercial building">Commercial Building</option>
                                <option value="land property">Land Property</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="offers">Offer Type</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="offer-types" id="offer-types" class="form-control d-block rounded-0">
                                <option value="sale">Sale</option>
                                <option value="rent">Rent</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="select-city">Select City</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="cities" id="select-city" class="form-control d-block rounded-0">
                                <option value="Khouribga">Khouribga</option>
                                <option value="Casablanca">Casablanca</option>
                                <option value="Rabat">Rabat</option>
                                <option value="Beni-Mellal">Beni-Mellal</option>
                                <option value="Tanger">Tanger</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" name="submit" class="btn btn-success text-white btn-block rounded-0" value="Search">
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="view-options bg-white py-3 px-3 d-md-flex align-items-center">
                    <div class="mr-auto">
                        <a href="index.php" class="icon-view view-module active"><span class="icon-view_module"></span></a>
                    </div>
                    <div class="ml-auto d-flex align-items-center">
                        <div>
                            <a href="<?php echo APPURL; ?>" class="view-list px-3 border-right active">All</a>
                            <a href="rent.php?type=rent" class="view-list px-3 border-right">Rent</a>
                            <a href="sale.php?type=sale" class="view-list px-3">Sale</a>
                            <a href="price.php?price=ASC" class="view-list px-3">Price Ascending</a>
                            <a href="price.php?price=DESC" class="view-list px-3">Price Descending</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section site-section-sm bg-light">
    <div class="container">
        <div class="row mb-5">
            <?php if (!empty($alllistings)) : ?>
                <?php foreach ($alllistings as $listing) : ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="property-entry h-100">
                            <a href="property-details.php?id=<?php echo $listing->id; ?>" class="property-thumbnail">
                                <div class="offer-type-wrap">
                                    <span class="offer-type bg-<?php echo $listing->type == "rent" ? "success" : "danger"; ?>"><?php echo $listing->type; ?></span>
                                </div>
                                <img src="<?php echo THUMBNAILSURL; ?>/<?php echo $listing->image; ?>" alt="Image" class="img-fluid">
                            </a>
                            <div class="p-4 property-body">
                                <h2 class="property-title"><a href="property-details.php?id=<?php echo $listing->id; ?>"><?php echo $listing->name; ?></a></h2>
                                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span><?php echo $listing->location; ?></span>
                                <strong class="property-price text-primary mb-3 d-block text-success">$<?php echo $listing->price; ?></strong>
                                <ul class="property-specs-wrap mb-3 mb-lg-0">
                                    <li>
                                        <span class="property-specs">Beds</span>
                                        <span class="property-specs-number"><?php echo $listing->beds; ?></span>
                                    </li>
                                    <li>
                                        <span class="property-specs">Baths</span>
                                        <span class="property-specs-number"><?php echo $listing->bath; ?></span>
                                    </li>
                                    <li>
                                        <span class="property-specs">SQ FT</span>
                                        <span class="property-specs-number"><?php echo $listing->sq_ft; ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div class="col-12">
                    <div class="bg-warning p-3 text-center">
                        No properties found for the selected category.
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php require '../includes/footer.php'; ?>