<!-- Sticky AI Chatbot Widget -->
<div id="chatbot-widget" class="cb-widget">

    <!-- Toggle Button -->
    <button class="cb-toggle" id="cb-toggle" aria-label="Open chat">
        <svg class="cb-icon-chat" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
        </svg>
        <svg class="cb-icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5" stroke-linecap="round">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div class="cb-window" id="cb-window">

        <!-- Header -->
        <div class="cb-header">
            <div class="cb-header-avatar">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
            </div>
            <div class="cb-header-info">
                <span class="cb-header-name">Abacart Support</span>
                <span class="cb-header-status"><i class="cb-dot"></i> Online</span>
            </div>
        </div>

        <!-- Messages -->
        <div class="cb-messages" id="cb-messages">
            <div class="cb-msg cb-bot">
                <div class="cb-bubble">
                    👋 Hi! Welcome to <strong>Abacart PH</strong>. How can I help you today?
                </div>
            </div>
            <!-- Quick Replies -->
            <div class="cb-quick-replies" id="cb-quick-replies">
                <button class="cb-chip" data-msg="What is Abacart?">About Us</button>
                <button class="cb-chip" data-msg="What products do you have?">Our Products</button>
                <button class="cb-chip" data-msg="How does shipping work?">Shipping</button>
                <button class="cb-chip" data-msg="How do I return an item?">Returns</button>
            </div>
        </div>

        <!-- Input -->
        <div class="cb-input-wrap">
            <form id="cb-form" class="cb-form" autocomplete="off">
                <input type="text" id="cb-input" class="cb-input" placeholder="Type a message…" autocomplete="off">
                <button type="submit" class="cb-send" aria-label="Send">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                    </svg>
                </button>
            </form>
        </div>

    </div>
</div>

<style>
    /* ── Root & Reset ─────────────────────────────── */
    .cb-widget {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    /* ── Toggle Button ────────────────────────────── */
    .cb-toggle {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #634d3a;
        border: none;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(99, 77, 58, 0.35);
        transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
        margin-left: auto;
        position: relative;
    }

    .cb-toggle:hover {
        background: #4d3b2c;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 77, 58, 0.4);
    }

    .cb-toggle:active {
        transform: scale(0.96);
    }

    .cb-icon-chat,
    .cb-icon-close {
        position: absolute;
        transition: opacity 0.2s, transform 0.2s;
    }

    .cb-icon-close {
        opacity: 0;
        transform: rotate(-90deg);
    }

    .cb-icon-chat {
        opacity: 1;
        transform: rotate(0deg);
    }

    .cb-widget.is-open .cb-icon-chat {
        opacity: 0;
        transform: rotate(90deg);
    }

    .cb-widget.is-open .cb-icon-close {
        opacity: 1;
        transform: rotate(0deg);
    }

    /* ── Chat Window ──────────────────────────────── */
    .cb-window {
        position: absolute;
        bottom: 64px;
        right: 0;
        width: 340px;
        max-width: calc(100vw - 24px);
        height: 480px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(44, 36, 32, 0.14);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        pointer-events: none;
        opacity: 0;
        transform: translateY(12px) scale(0.97);
        transition: opacity 0.22s ease, transform 0.22s ease;
    }

    .cb-widget.is-open .cb-window {
        pointer-events: all;
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    /* ── Header ───────────────────────────────────── */
    .cb-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #634d3a;
        flex-shrink: 0;
    }

    .cb-header-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
    }

    .cb-header-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .cb-header-name {
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.01em;
    }

    .cb-header-status {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .cb-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #6ee36e;
        display: inline-block;
        flex-shrink: 0;
    }

    /* ── Messages ─────────────────────────────────── */
    .cb-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: #fafaf8;
        scroll-behavior: smooth;
    }

    .cb-messages::-webkit-scrollbar {
        width: 4px;
    }

    .cb-messages::-webkit-scrollbar-track {
        background: transparent;
    }

    .cb-messages::-webkit-scrollbar-thumb {
        background: rgba(99, 77, 58, 0.12);
        border-radius: 4px;
    }

    /* Bubbles */
    .cb-msg {
        display: flex;
        animation: cb-fadein 0.18s ease;
    }

    @keyframes cb-fadein {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .cb-bot {
        justify-content: flex-start;
    }

    .cb-user {
        justify-content: flex-end;
    }

    .cb-bubble {
        max-width: 78%;
        padding: 9px 13px;
        border-radius: 14px;
        font-size: 13px;
        line-height: 1.55;
        word-break: break-word;
    }

    .cb-bot .cb-bubble {
        background: #fff;
        color: #2c2420;
        border-bottom-left-radius: 4px;
        border: 1px solid rgba(99, 77, 58, 0.08);
        box-shadow: 0 1px 4px rgba(99, 77, 58, 0.06);
    }

    .cb-user .cb-bubble {
        background: #634d3a;
        color: #fff;
        border-bottom-right-radius: 4px;
    }

    /* Quick Reply Chips */
    .cb-quick-replies {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding-top: 2px;
    }

    .cb-chip {
        padding: 5px 12px;
        border-radius: 20px;
        border: 1px solid rgba(99, 77, 58, 0.25);
        background: #fff;
        color: #634d3a;
        font-size: 11.5px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.18s;
        font-family: inherit;
    }

    .cb-chip:hover {
        background: #634d3a;
        color: #fff;
        border-color: #634d3a;
    }

    /* Typing Indicator */
    .cb-typing .cb-bubble {
        display: flex;
        gap: 4px;
        align-items: center;
        padding: 10px 14px;
    }

    .cb-typing .cb-bubble span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #b5a89e;
        display: inline-block;
        animation: cb-bounce 1.3s infinite ease-in-out;
    }

    .cb-typing .cb-bubble span:nth-child(2) {
        animation-delay: 0.18s;
    }

    .cb-typing .cb-bubble span:nth-child(3) {
        animation-delay: 0.36s;
    }

    @keyframes cb-bounce {

        0%,
        60%,
        100% {
            transform: translateY(0);
        }

        30% {
            transform: translateY(-7px);
        }
    }

    /* ── Input ────────────────────────────────────── */
    .cb-input-wrap {
        padding: 10px 12px;
        border-top: 1px solid rgba(99, 77, 58, 0.07);
        background: #fff;
        flex-shrink: 0;
    }

    .cb-form {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .cb-input {
        flex: 1;
        border: 1px solid rgba(99, 77, 58, 0.15);
        border-radius: 22px;
        padding: 8px 14px;
        font-size: 13px;
        font-family: inherit;
        color: #2c2420;
        background: #fafaf8;
        outline: none;
        transition: border-color 0.2s;
    }

    .cb-input::placeholder {
        color: #bbb;
    }

    .cb-input:focus {
        border-color: #634d3a;
        background: #fff;
    }

    .cb-send {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: none;
        background: #634d3a;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background 0.2s, transform 0.15s;
        padding-left: 2px;
    }

    .cb-send:hover {
        background: #4d3b2c;
    }

    .cb-send:active {
        transform: scale(0.93);
    }

    /* ── Mobile ───────────────────────────────────── */
    @media (max-width: 480px) {
        .cb-widget {
            bottom: 14px;
            right: 14px;
        }

        .cb-window {
            width: calc(100vw - 28px);
            right: -14px;
            height: 70vh;
            max-height: 520px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const widget = document.getElementById('chatbot-widget');
        const toggle = document.getElementById('cb-toggle');
        const window_ = document.getElementById('cb-window');
        const form = document.getElementById('cb-form');
        const input = document.getElementById('cb-input');
        const messages = document.getElementById('cb-messages');
        const quickReplies = document.getElementById('cb-quick-replies');

        // ── Open / Close ───────────────────────────────
        toggle.addEventListener('click', () => {
            widget.classList.toggle('is-open');
            if (widget.classList.contains('is-open')) {
                input.focus();
            }
        });

        // ── Quick Reply Chips ──────────────────────────
        document.querySelectorAll('.cb-chip').forEach(chip => {
            chip.addEventListener('click', () => {
                const msg = chip.dataset.msg;
                quickReplies.remove();
                sendMessage(msg);
            });
        });

        // ── Form Submit ────────────────────────────────
        form.addEventListener('submit', e => {
            e.preventDefault();
            const msg = input.value.trim();
            if (!msg) return;
            input.value = '';
            sendMessage(msg);
        });

        // ── Send Flow ──────────────────────────────────
        function sendMessage(msg) {
            addMsg(msg, 'user');
            const typingEl = addTyping();
            setTimeout(() => {
                typingEl.remove();
                const reply = getBotReply(msg);
                addMsg(reply, 'bot');
            }, 700);
        }

        // ── Add Message ────────────────────────────────
        function addMsg(text, who) {
            const wrap = document.createElement('div');
            wrap.className = `cb-msg cb-${who}`;

            const bubble = document.createElement('div');
            bubble.className = 'cb-bubble';

            // Render newlines and escape HTML safely
            if (who === 'bot') {
                bubble.innerHTML = escapeHtml(text).replace(/\n/g, '<br>');
            } else {
                bubble.textContent = text;
            }

            wrap.appendChild(bubble);
            messages.appendChild(wrap);
            scrollBottom();
            return wrap;
        }

        // ── Typing Indicator ───────────────────────────
        function addTyping() {
            const wrap = document.createElement('div');
            wrap.className = 'cb-msg cb-bot cb-typing';
            wrap.innerHTML = '<div class="cb-bubble"><span></span><span></span><span></span></div>';
            messages.appendChild(wrap);
            scrollBottom();
            return wrap;
        }

        function scrollBottom() {
            messages.scrollTop = messages.scrollHeight;
        }

        function escapeHtml(str) {
            const d = document.createElement('div');
            d.textContent = str;
            return d.innerHTML;
        }

        // ── Bot Responses ──────────────────────────────
        function getBotReply(userMessage) {
            const msg = userMessage.toLowerCase();

            // ── About / System ─────────────────────────
            if (msg.includes('what is abacart') || msg.includes('about abacart') || msg.includes('what are you') || msg.includes('tell me about') || msg.includes('who are you') || msg.includes('abacart ph')) {
                return 'Abacart PH is a Filipino e-commerce store dedicated to authentic, handwoven abaca products. We partner directly with local artisans to bring you sustainable, eco-friendly goods that celebrate Filipino heritage and craftsmanship. 🌿';
            }
            if (msg.includes('mission') || msg.includes('vision') || msg.includes('goal') || msg.includes('purpose')) {
                return 'Our mission is to bring handcrafted Filipino abaca products to the world while empowering local weaving communities. We believe small changes — like choosing sustainable goods — can make a big impact on the planet and on people\'s lives.';
            }
            if (msg.includes('sustainability') || msg.includes('sustainable') || msg.includes('eco') || msg.includes('environment')) {
                return 'Sustainability is at our core! From natural abaca fibers to our eco-friendly packaging, every decision we make is planet-conscious. Abaca is a 100% natural plant fiber, making our products fully biodegradable. 🌱';
            }
            if (msg.includes('artisan') || msg.includes('handmade') || msg.includes('handcraft') || msg.includes('weav') || msg.includes('craft')) {
                return 'Every Abacart product is handwoven by skilled Filipino artisans. We work exclusively with local weaving communities, ensuring fair wages and a global platform for their incredible talent. No two pieces are exactly alike!';
            }
            if (msg.includes('abaca') || msg.includes('fiber') || msg.includes('material')) {
                return 'Abaca (Manila hemp) is a natural plant fiber from the Philippines, known for its strength, durability, and biodegradability. Our artisans hand-weave it into beautiful, functional products — one of the strongest natural fibers in the world!';
            }

            // ── Products ───────────────────────────────
            if (msg.includes('product') || msg.includes('what do you sell') || msg.includes('what do you have') || msg.includes('items') || msg.includes('collection')) {
                return 'We carry four main categories of handwoven abaca products:\n\n🛍️ Bags — stylish totes, handbags & everyday carry\n🏠 Home Decor — baskets, storage & accent pieces\n💎 Accessories — fans, jewelry & fashion accents\n🎁 Souvenirs — unique Filipino keepsakes & gifts\n\nBrowse our full collection in the Shop!';
            }
            if (msg.includes('bag') || msg.includes('tote') || msg.includes('purse') || msg.includes('handbag')) {
                return 'Our Abaca Bags are a best-seller! Artisanal fashion for everyday use — from structured totes to casual handbags, all handwoven from natural abaca fibers. Durable, stylish, and eco-friendly. Visit our Shop to see all styles!';
            }
            if (msg.includes('basket') || msg.includes('home decor') || msg.includes('decor') || msg.includes('storage') || msg.includes('home')) {
                return 'Our Abaca Baskets are perfect for sustainable home storage! Available in various sizes, they double as beautiful décor accents. Check our Home Decor category for table centerpieces, wall pieces, and more!';
            }
            if (msg.includes('fan') || msg.includes('hand fan') || msg.includes('pamaypay')) {
                return 'Our Abaca Hand Fans are a traditional Filipino favorite! Lightweight, beautiful, and handcrafted — tradition in the palm of your hand. They also make wonderful souvenirs and gifts. 🌬️';
            }
            if (msg.includes('accessories') || msg.includes('jewelry') || msg.includes('accessory')) {
                return 'Our Accessories category features handwoven abaca fashion accents — including fans, wristbands, and decorative pieces. Perfect for adding a natural, artisanal touch to your look!';
            }
            if (msg.includes('souvenir') || msg.includes('gift') || msg.includes('pasalubong')) {
                return 'Looking for a unique Filipino souvenir? Our Souvenirs category has beautiful handcrafted keepsakes made from abaca — perfect pasalubong or gifts for loved ones! 🎁';
            }
            if (msg.includes('best') || msg.includes('popular') || msg.includes('top') || msg.includes('featured')) {
                return 'Our best-selling products are:\n\n⭐ Abaca Baskets — sustainable home storage\n⭐ Abaca Bags — artisanal everyday fashion\n⭐ Abaca Hand Fans — traditional Filipino craftsmanship\n\nVisit our Shop to see the full collection!';
            }
            if (msg.includes('categor') || msg.includes('type') || msg.includes('kind')) {
                return 'We have 4 product categories:\n🛍️ Bags\n🏠 Home Decor\n💎 Accessories\n🎁 Souvenirs\n\nEach item is uniquely handwoven by Filipino artisans. Head to the Shop to explore!';
            }

            // ── Shopping & Orders ──────────────────────
            if (msg.includes('price') || msg.includes('cost') || msg.includes('how much') || msg.includes('magkano')) {
                return 'Pricing varies per product and is listed on each product page in our Shop. We offer both regular and sale prices. Keep an eye out for promos and discounted items! 💰';
            }
            if (msg.includes('sale') || msg.includes('discount') || msg.includes('promo') || msg.includes('coupon') || msg.includes('voucher')) {
                return 'We do run sales and have coupon codes available! Check our Shop for items marked "On Sale" and look out for promo codes you can apply at checkout. 🎉';
            }
            if (msg.includes('ship') || msg.includes('deliver') || msg.includes('delivery') || msg.includes('padala')) {
                return 'We offer shipping across the Philippines! Delivery times vary by location. You\'ll receive tracking information once your order is dispatched. 📦';
            }
            if (msg.includes('order') || msg.includes('purchase') || msg.includes('buy') || msg.includes('cart')) {
                return 'To place an order: browse our Shop, add items to your cart, and proceed to checkout. You can view and track your orders anytime in your Account dashboard. 🛒';
            }
            if (msg.includes('payment') || msg.includes('pay') || msg.includes('bayad') || msg.includes('gcash') || msg.includes('credit')) {
                return 'We accept multiple payment methods including major credit/debit cards and online payment options. All transactions are secured and encrypted for your safety. 🔒';
            }
            if (msg.includes('return') || msg.includes('refund') || msg.includes('exchange') || msg.includes('palitan')) {
                return 'We have a hassle-free return policy. Returns and exchanges are processed within 5–7 business days. Contact our support team with your order details to get started.';
            }
            if (msg.includes('account') || msg.includes('register') || msg.includes('sign up') || msg.includes('login') || msg.includes('log in')) {
                return 'You can create a free account to track orders, save your wishlist, and manage your profile. Click "Register" or "Login" in the navigation bar to get started!';
            }
            if (msg.includes('wishlist') || msg.includes('save') || msg.includes('favorite')) {
                return 'You can save products to your Wishlist for later! Just log in and click the wishlist icon on any product. Great for gift planning too! 💝';
            }

            // ── Help & Support ─────────────────────────
            if (msg.includes('help') || msg.includes('support') || msg.includes('contact') || msg.includes('assist')) {
                return 'Need help? You can:\n📧 Visit our Contact page for support\n🛒 Check our Shop or your Account dashboard\n💬 Keep chatting with me!\n\nWe\'re always happy to assist you.';
            }
            if (msg.includes('hello') || msg.includes('hi') || msg.includes('hey') || msg.includes('good morning') || msg.includes('good afternoon') || msg.includes('kumusta')) {
                return 'Hello! 👋 Welcome to Abacart PH — your home for authentic Filipino handwoven abaca products. How can I assist you today?';
            }
            if (msg.includes('thank') || msg.includes('salamat') || msg.includes('appreciate')) {
                return 'You\'re very welcome! Salamat for supporting Filipino craftsmanship. 🙏 Feel free to ask if you need anything else!';
            }

            const fallback = [
                'I\'m here to help! Ask me about our products, shipping, orders, or what Abacart PH is all about. 😊',
                'Try asking about our Bags, Home Decor, Accessories, or Souvenirs!',
                'Feel free to ask me about our abaca products, delivery, returns, or anything else!',
                'Not sure where to start? Ask me about our best-sellers or browse the Shop!'
            ];
            return fallback[Math.floor(Math.random() * fallback.length)];
        }
    });
</script>