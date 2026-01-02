<style>
/* Animated Background Image Slideshow */
.animated-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  overflow: hidden;
}

.animated-background::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.5);
  z-index: 1;
}

body.dark-mode .animated-background::before {
  background: rgba(24, 26, 27, 0.6);
}

.bg-slide {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  opacity: 0;
  animation: slideShow 190s infinite;
}

/* Stagger the animation for each image */
<?php
$images = [
  'basmati rice.jpg',
  'blueband 2.jpg',
  'bluebands 1.png',
  'bon7 2.jpg',
  'bond7.jpg',
  'cotex supa.jpg',
  'crystal sunflower.jpg',
  'dunhill cigarrate.jpg',
  'fontera powder.jpg',
  'gilbey\'s 2.jpg',
  'gilbey\'s.jpg',
  'highland 2.jpg',
  'highland milk.jpg',
  'impala cigarettes.jpg',
  'indian rice.jpg',
  'intore cigarettes.jpg',
  'inyange 2 milk.jpg',
  'inyange milk.jpg',
  'iturize 3.jpg',
  'iturize.jpg',
  'loa wipes 1.jpg',
  'loa wipes 2.jpg',
  'majura rice.jpg',
  'mamylove.jpg',
  'mayonaise american.jpg',
  'mayonaise citro.jpg',
  'mayonaise jambo.jpg',
  'meru.jpg',
  'movit.jpg',
  'mugurusi.jpg',
  'mukamira milk.jpg',
  'nbg gin.jpg',
  'ngufu gine 2.jpeg',
  'ngufu gine.jpg',
  'rices.jpg',
  'topline.jpg',
  'topmilk.jpg',
  'wipes iturize.jpg',
  'zahabu meru.jpg'
];

$totalImages = count($images);
$delayPerImage = 5; // seconds per image

for ($i = 0; $i < $totalImages; $i++) {
  $delay = $i * $delayPerImage;
  echo ".bg-slide:nth-child(" . ($i + 1) . ") {\n";
  echo "  animation-delay: {$delay}s;\n";
  echo "}\n";
}
?>

@keyframes slideShow {
  0% { opacity: 0; transform: scale(1); }
  2% { opacity: 1; transform: scale(1.05); }
  <?php 
  $percentagePerImage = 100 / $totalImages;
  $showPercentage = ($delayPerImage / ($totalImages * $delayPerImage)) * 100;
  echo number_format($showPercentage, 2);
  ?>% { opacity: 1; transform: scale(1.05); }
  <?php 
  echo number_format($showPercentage + 2, 2);
  ?>% { opacity: 0; transform: scale(1); }
  100% { opacity: 0; transform: scale(1); }
}
</style>

<div class="animated-background">
  <?php foreach ($images as $image): ?>
  <div class="bg-slide" style="background-image: url('images/<?= htmlspecialchars($image) ?>');"></div>
  <?php endforeach; ?>
</div>
