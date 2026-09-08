Artistiqe Project Summary
What is this project about?
Based on a detailed exploration of the source code, Artistiqe is a comprehensive, multi-vendor E-commerce platform with a specific focus on Art, Artworks, and Artists. While it possesses all standard e-commerce capabilities (cart, checkout, shipping, coupons), it uniquely caters to the art industry by providing specialized registrations and features for Artists, Collectors, and Galleries, along with an Auction/Bidding system for artwork.

Additionally, the presence of a Postman collection (FlutterEcommerceAPI.postman_collection.json) strongly indicates that this backend also serves as a RESTful API for a companion Flutter mobile application.

Tech Stack
Framework: Laravel 10 (PHP ^8.2)
Frontend: Blade templating with likely Vue.js/React integrations via Laravel Mix (webpack.mix.js and package.json).
Database: MySQL/MariaDB (standard for Laravel, evidenced by shop.sql database dump).
Payment Integrations: Extensive global payment gateways including Stripe, Razorpay, Paytm, SSLCommerz, MercadoPago, Paystack, Instamojo, and more.
Comprehensive Module Breakdown
Here is a detailed breakdown of the project's modules, determined by analyzing the Models and Controllers:

1. User & Identity Management
The platform supports a complex multi-role ecosystem, extending beyond typical e-commerce:

Standard Roles: Customer, Admin, Staff (with granular Role and Permission management).
Art-Specific Roles:
Artist: Specialized registration for artists (ArtistRegisterController).
Collector: For art collectors (CollectorRegisterController).
Gallery: For physical or digital art galleries (GalleryRegisterController).
Vendor Roles: Seller (Multi-vendor support).
Delivery: DeliveryBoy (In-house or 3rd party delivery staff).
Affiliates: AffiliateUser (For marketing and referral programs).
2. Multi-Vendor System
The platform operates as a marketplace (like Etsy or Amazon) rather than just a single-store:

Shops & Sellers: Sellers can create shops (Shop, SellerController).
Packages: Sellers can subscribe to specific business plans (SellerPackage, SellerPackagePayment).
Commissions & Payouts: The platform tracks commissions per sale (CommissionHistory) and handles withdrawal requests from sellers (SellerWithdrawRequest).
3. Catalog & Product Management
A highly robust product management system:

Core Entities: Product, Artwork, Category, SubCategory, Brand.
Attributes & Variations: Products can have complex variations like SizeChart, Color, and custom Attribute (e.g., frame type, canvas type).
Pre-orders: Extensive support for pre-ordering items (PreorderProduct, PreorderDiscount, PreorderStock).
Auctions/Bidding: An auction module allowing users to bid on artwork (AuctionProductBid, BidController).
Digital Products: Support for downloadable/digital goods (DigitalProductController).
4. Sales & Order Lifecycle
Cart & Checkout: Cart, CheckoutController.
Orders: Order tracking, multi-vendor combined orders (Order, CombinedOrder, OrderDetail).
Invoicing: Automatic invoice generation (InvoiceController).
Refunds: Return and refund request handling (RefundRequest).
5. Shipping & Logistics
Carriers & Zones: Definition of shipping zones and carriers (Carrier, Zone, CarrierRangePrice).
Delivery Boys: Assignment of orders to delivery personnel (DeliveryBoyCollection, DeliveryHistory).
Pickup Points: Optional in-person pickup points for buyers (PickupPoint).
6. Marketing, Promotions & Affiliates
Flash Deals & Discounts: Limited-time offers (FlashDeal, FlashDealProduct).
Coupons: Discount codes (Coupon, CouponUsage).
Affiliate System: Users can earn by referring others (AffiliateLog, AffiliateEarningDetail, AffiliateWithdrawRequest).
Customer Loyalty: Club points system for loyal customers (ClubPoint, ClubPointDetail).
7. Financial & Payments
Wallets: Digital wallets for users to store funds (Wallet, WalletController).
Transactions: Logging all financial movements (Transaction).
Gateways: Managed via PaymentController and PaymentMethod.
8. Customer Support & Communication
Support Tickets: Helpdesk system for users (Ticket, TicketReply).
Messaging/Chat: Direct communication between buyers and sellers (Conversation, Message).
Reviews & Ratings: Product feedback (Review).
Blogs: Integrated content management for articles and news (Blog, BlogCategory).
9. Application & Business Settings
Localization: Multi-language and translation support (Language, Translation, CityTranslation).
Configuration: Site-wide settings, themes, dynamic popups, and policies (BusinessSetting, DynamicPopup, Policy).
Notifications: Push notifications (Firebase), Emails, and SMS (FirebaseNotification, EmailTemplate, SmsTemplate).
Summary
Artistiqe is a powerful Laravel-based B2B/B2C marketplace tailored for the art community. It successfully merges a complex multi-vendor e-commerce architecture (handling shipping, diverse payments, and seller payouts) with niche features like Artist/Gallery accounts and Artwork Bidding. It is built to serve both a web frontend and a Flutter mobile application via its API.

