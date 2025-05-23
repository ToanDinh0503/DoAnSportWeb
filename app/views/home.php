<?php
require_once __DIR__ . '/../controllers/ProductController.php';

$productController = new ProductController();
$featuredProducts = $productController->getFeaturedProducts(8);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Elite - Thiết Bị Thể Thao Cao Cấp</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/WebbandoTT/app/public/css/style.css" rel="stylesheet">
</head>
<body>
    <?php 
    include __DIR__ . '/../../includes/header.php'; 
    ?>

    <!-- Main Content -->
    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/WebbandoTT/app/public/images/sliders/slider1.jpg" class="d-block w-100" alt="Sports Equipment">
                <div class="carousel-caption">
                    <h1>Thiết Bị Thể Thao Cao Cấp</h1>
                    <p class="d-none d-md-block">Nâng tầm đẳng cấp tập luyện của bạn</p>
                    <a href="/WebbandoTT/san-pham" class="btn btn-light btn-lg">Khám Phá Ngay</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/WebbandoTT/app/public/images/sliders/slider2.jpg" class="d-block w-100" alt="Training">
                <div class="carousel-caption">
                    <h1>Dụng Cụ Tập Luyện</h1>
                    <p>Nâng cao hiệu quả tập luyện</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/WebbandoTT/app/public/images/sliders/slider3.jpg" class="d-block w-100" alt="Accessories">
                <div class="carousel-caption">
                    <h1>Phụ Kiện Thể Thao</h1>
                    <p>Đa dạng - Chất lượng - Bền bỉ</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Categories Section -->
    <section class="categories bg-light" style="padding: 100px 0 50px 0;">
        <div class="container">
            <h2 class="section-title">DANH MỤC SẢN PHẨM</h2>
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="category-card text-center p-4 hover-shadow">
                        <i class="bi bi-bicycle display-4 text-primary mb-3"></i>
                        <h5>Thiết bị tập gym</h5>
                        <p>Dụng cụ tập luyện chuyên nghiệp</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="category-card text-center p-4 hover-shadow">
                        <i class="bi bi-dribbble display-4 text-primary mb-3"></i>
                        <h5>Thể thao đồng đội</h5>
                        <p>Bóng đá, bóng rổ, cầu lông</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="category-card text-center p-4 hover-shadow">
                        <i class="bi bi-smartwatch display-4 text-primary mb-3"></i>
                        <h5>Phụ kiện thể thao</h5>
                        <p>Đồng hồ, găng tay, phụ kiện</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="brands py-5">
        <div class="container">
            <h2 class="section-title">THƯƠNG HIỆU NỔI TIẾNG</h2>
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-4 col-6">
                    <img src="/WebbandoTT/app/public/images/brands/nike.png" alt="Nike" class="img-fluid brand-logo">
                </div>  
                <div class="col-lg-2 col-md-4 col-6">
                    <img src="/WebbandoTT/app/public/images/brands/adidas.png" alt="Adidas" class="img-fluid brand-logo">
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <img src="/WebbandoTT/app/public/images/brands/puma.png" alt="Puma" class="img-fluid brand-logo">
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <img src="/WebbandoTT/app/public/images/brands/under-armour.png" alt="Under Armour" class="img-fluid brand-logo">
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <img src="/WebbandoTT/app/public/images/brands/reebok.png" alt="Reebok" class="img-fluid brand-logo">
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <img src="/WebbandoTT/app/public/images/brands/new-balance.png" alt="New Balance" class="img-fluid brand-logo">
                </div>
            </div>
        </div>
    </section>

    <section class="featured-products bg-light">
        <div class="container">
            <h2 class="section-title">SẢN PHẨM NỔI BẬT</h2>
            <div class="row g-4">
                <?php
                if (!empty($featuredProducts)) {
                    foreach ($featuredProducts as $product) {
                        $imagePath = $product['hinh_anh'] 
                            ? "/WebbandoTT/public/uploads/products/" . $product['hinh_anh']
                            : "/WebbandoTT/app/public/images/products/no-image.jpg";
                        ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="product-card">
                                <div class="product-badge">-20%</div>
                                <div class="product-image">
                                    <a href="/WebbandoTT/san-pham/<?= htmlspecialchars($product['ma_sp']) ?>" class="product-link">
                                        <img src="<?= htmlspecialchars($imagePath) ?>" 
                                             alt="<?= htmlspecialchars($product['ten_sp']) ?>"
                                             class="img-fluid">
                                    </a>
                                    <div class="product-actions">
                                        <button class="btn btn-light btn-sm add-to-cart" data-product-id="<?= $product["id"] ?? 0 ?>">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                        <a href="/WebbandoTT/san-pham/<?= htmlspecialchars($product['ma_sp']) ?>" class="btn btn-light btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <a href="/WebbandoTT/san-pham/<?= htmlspecialchars($product['ma_sp']) ?>" class="text-decoration-none">
                                        <h3 class="product-title"><?= htmlspecialchars($product['ten_sp']) ?></h3>
                                    </a>
                                    <div class="product-price">
                                        <span class="price-new"><?= number_format($product['gia_khuyen_mai'] ?? $product['gia']) ?>₫</span>
                                        <span class="price-old"><?= number_format($product['gia']) ?>₫</span>
                                    </div>
                                    <div class="product-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <span>(4.5)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p>Không có sản phẩm nổi bật</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Stats Counter Section -->
    <section class="stats-counter">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="counter-box">
                        <div class="counter-number">5000+</div>
                        <div class="counter-label">Khách hàng hài lòng</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="counter-box">
                        <div class="counter-number">1000+</div>
                        <div class="counter-label">Sản phẩm đa dạng</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="counter-box">
                        <div class="counter-number">15+</div>
                        <div class="counter-label">Năm kinh nghiệm</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="counter-box">
                        <div class="counter-number">50+</div>
                        <div class="counter-label">Thương hiệu hợp tác</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features bg-light">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <i class="bi bi-truck display-4 text-primary"></i>
                    <h3 class="mt-3">Giao Hàng Miễn Phí</h3>
                    <p>Cho đơn hàng từ 500.000₫</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-shield-check display-4 text-primary"></i>
                    <h3 class="mt-3">Bảo Hành 12 Tháng</h3>
                    <p>Đổi trả trong 30 ngày</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-headset display-4 text-primary"></i>
                    <h3 class="mt-3">Hỗ Trợ 24/7</h3>
                    <p>Tư vấn chuyên nghiệp</p>
                </div>
            </div>
        </div>
        <hr>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us bg-light">
        <div class="container">
            <h3 class="section-title">TẠI SAO CHỌN SPORT ELITE ?</h3>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <i class="bi bi-patch-check-fill feature-icon"></i>
                        <h5>Sản Phẩm Chính Hãng</h5>
                        <p>100% sản phẩm được nhập khẩu trực tiếp từ nhà sản xuất với chứng nhận chính hãng</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <i class="bi bi-currency-dollar feature-icon"></i>
                        <h5>Giá Cả Hợp Lý</h5>
                        <p>Cam kết giá tốt nhất thị trường với nhiều chương trình khuyến mãi hấp dẫn</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <i class="bi bi-headset feature-icon"></i>
                        <h5>Hỗ Trợ 24/7</h5>
                        <p>Đội ngũ tư vấn chuyên nghiệp, nhiệt tình hỗ trợ khách hàng mọi lúc</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <i class="bi bi-arrow-repeat feature-icon"></i>
                        <h5>Chính Sách Đổi Trả</h5>
                        <p>Đổi trả miễn phí trong 30 ngày nếu sản phẩm có lỗi từ nhà sản xuất</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials py-5">
        <div class="container">
            <h2 class="section-title">KHÁCH HÀNG NÓI GÌ ?</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="rating mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <p class="testimonial-text">"Sản phẩm chất lượng cao, đóng gói cẩn thận. Nhân viên tư vấn nhiệt tình, giao hàng đúng hẹn."</p>
                        </div>
                        <div class="testimonial-author d-flex align-items-center mt-4">
                            <img src="images/testimonials/user1.jpg" alt="Nguyễn Văn A" class="rounded-circle" width="60">
                            <div class="ms-3">
                                <h5 class="mb-1">Nguyễn Văn A</h5>
                                <small class="text-muted">Huấn luyện viên thể hình</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="rating mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-half text-warning"></i>
                            </div>
                            <p class="testimonial-text">"Mình rất hài lòng với dịch vụ của Sport Elite. Giá cả phải chăng, sản phẩm đúng như mô tả."</p>
                        </div>
                        <div class="testimonial-author d-flex align-items-center mt-4">
                            <img src="images/testimonials/user2.jpg" alt="Trần Thị B" class="rounded-circle" width="60">
                            <div class="ms-3">
                                <h5 class="mb-1">Trần Thị B</h5>
                                <small class="text-muted">Giáo viên yoga</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="rating mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <p class="testimonial-text">"Đã mua nhiều lần tại Sport Elite. Chất lượng sản phẩm và dịch vụ luôn được duy trì ổn định."</p>
                        </div>
                        <div class="testimonial-author d-flex align-items-center mt-4">
                            <img src="images/testimonials/user3.jpg" alt="Lê Văn C" class="rounded-circle" width="60">
                            <div class="ms-3">
                                <h5 class="mb-1">Lê Văn C</h5>
                                <small class="text-muted">Vận động viên chuyên nghiệp</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../../includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/WebbandoTT/app/public/js/main.js"></script>
</body>
</html>