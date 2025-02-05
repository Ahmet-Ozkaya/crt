<?php
require_once 'db.php';

// Get top 5 categories with job counts
$query = "SELECT category AS name, COUNT(id) AS job_count
          FROM jobs
          GROUP BY category
          ORDER BY job_count DESC
          LIMIT 5";
$result = mysqli_query($conn, $query);

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}
?>

<section class="categories-section section-padding" id="categories-section">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-12 col-12 text-center">
                <h2 class="mb-5">Browse by <span>Categories</span></h2>
            </div>

            <?php foreach ($categories as $category): ?>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="categories-block">
                    <a href="jcategories.php?category=<?= urlencode($category['name']) ?>" class="d-flex flex-column justify-content-center align-items-center h-100">
                        <i class="categories-icon bi-window"></i>
                        <small class="categories-block-title"><?= htmlspecialchars($category['name']) ?></small>
                        <div class="categories-block-number d-flex flex-column justify-content-center align-items-center">
                            <span class="categories-block-number-text"><?= $category['job_count'] ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
