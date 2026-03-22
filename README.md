# Abacart_PH - E-commerce Platform

A modern e-commerce platform built with Laravel 12, featuring a robust admin dashboard and a clean user interface.

## Features

### User Interface
- **Home Page**: Dynamic sliders, featured products, and a conditional Sale section that only appears when products are on sale.
- **Shop**: Comprehensive product listing with category filtering, price range selection, and sorting options (newest, price).
- **Product Details**: High-quality images with gallery support, detailed descriptions, and related product suggestions.
- **Shopping Cart**: AJAX-based management, item quantities, and coupon application for discounts.
- **Wishlist**: Save favorite items for later or move them directly to the cart.
- **Checkout**: Seamless multi-step process with address management and order notes.
- **User Dashboard**: Integrated profile management directly in the dashboard (Update Name, Phone, Password, and **Profile Image**).
- **Notifications**: Real-time alerts for order status changes (Delivered/Canceled) accessible via the user header.
- **Profile Image Display**: User profile images are displayed in the header for a personalized experience.
- **Static Pages**: Professional "About Us" and "Contact Us" pages for business information.

### Admin Dashboard
- **Admin Hub**: Centralized dashboard for sales analytics and order overviews.
- **Inventory Management**: Full control over products (including multi-image galleries, sale toggles, and stock status) and categories.
- **Order Management**: Detailed order tracking with status filtering (Ordered, Delivered, Canceled) and visibility of customer messages.
- **Coupon Management**: Create and manage discount codes, including expiry dates and minimum cart values.
- **Profile Management**: Dedicated administrator profile with role identification, and full account management (Name, Phone, Password, and **Profile Image**).

## Database Structure

The project uses a structured relational database with custom primary keys for consistency.

- **users**: `User_ID`, `name`, `email`, `utype` (ADM/USR), `image`, `phone_number`.
- **categories**: `Category_ID`, `category_name`, `category_slug`, `image`.
- **products**: `Product_ID`, `Product_Name`, `product_slug`, `short_description`, `description`, `regular_price`, `sale_price`, `SKU`, `stock_status`, `featured`, `quantity`, `image`, `images`, `Category_ID`, `is_on_sale`.
- **orders**: `Order_ID`, `User_ID`, `subtotal`, `discount`, `tax`, `total`, `name`, `phone`, `locality`, `address`, `city`, `province`, `country`, `landmark`, `zip`, `order_status`, `is_shipping_different`, `date_delivery`, `date_cancelled`, `Coupon_ID`, `Address_ID`, `note`.
- **order_items**: `Order_Item_ID`, `Product_ID`, `Order_ID`, `price`, `quantity`, `options`, `rstatus`.
- **addresses**: `Address_ID`, `User_ID`, `name`, `phone`, `locality`, `Zone_Street_HouseNumber`, `Barangay`, `City`, `Province`, `country`, `landmark`, `zip`, `address_type`, `is_default`.
- **coupons**: `Coupon_ID`, `code`, `type`, `value`, `cart_value`, `expiry_date`.
- **transactions**: `Transaction_ID`, `User_ID`, `Order_ID`, `payment_mode`, `status`.

## Project Structure

### Frontend (Blade Templates)
All views are located in `resources/views`.

- **Layouts**:
    - `layouts/app.blade.php`: The main layout for users. Contains the header, navigation, and footer.
    - `layouts/admin.blade.php`: The dashboard layout for administrators.

- **Key Pages**:
    - `index.blade.php`: Home page with sliders and hot deals.
    - `shop.blade.php`: Product listing with category and price filtering.
    - `details.blade.php`: Individual product details and related products.
    - `cart.blade.php` / `checkout.blade.php`: Shopping cart management and order placement.

- **Admin Sections**:
    - `admin/`: Contains all administrative views (Products, Categories, Orders, Coupons).

- **Frontend Assets**:
    - `public/assets/images/`: Images and icons.
    - `public/css/`: Main stylesheet.
    - `public/js/`: Javascript files for sliders, charts, and interactivity.

### Controllers
Located in `app/Http/Controllers`.

- **AdminController**: Manages the admin dashboard, including product inventory, category organization, discount coupons, and order processing.
- **UserController**: Handles user-specific data like profile updates, address management, and personal order history.
- **ShopController**: Manages the storefront, including searching and filtering products.
- **CartController**: Interfaces with the shopping cart package.
- **HomeController**: Manages static pages and landing page logic.

## Technical Details

### Shopping Cart Package
The project uses the `surfsidemedia/laravel-shopping-cart` package. 
> [!IMPORTANT]
> In Blade files, you will see the namespace `Surfsidemedia\Shoppingcart\Facades\Cart`. This is required for the cart functionality.

### Admin Redirection
Administrators are automatically redirected to the dashboard when they log in or access the home page while authenticated.

### Stock Management
The system includes stock validation and deduction upon order placement, with automatic restoration if an order is canceled.
