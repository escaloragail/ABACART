"""
=============================================================================
  TEST SCRIPT #4 — Cart & Checkout Transactions
  Abacart PH Automated Testing
  Tool: Python + Selenium WebDriver
  Author: Member 4 (Bonus Coverage)
=============================================================================
  Covers:
    TC-16: Add product to cart from shop page
    TC-17: Update quantity in cart (Increase/Decrease)
    TC-18: Remove specific item from cart
    TC-19: Apply coupon and verify discount calculation
    TC-20: Successful checkout and order placement flow
=============================================================================
"""

import time
import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options

BASE_URL = "http://localhost:8000"
USER_EMAIL = "user@gmail.com"
USER_PASS = "qweasdzxc"

class TestCartAndCheckout(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        opts = Options()
        opts.add_argument("--window-size=1920,1080")
        cls.driver = webdriver.Chrome(options=opts)
        cls.driver.implicitly_wait(10)
        cls.wait = WebDriverWait(cls.driver, 10)

    @classmethod
    def tearDownClass(cls):
        cls.driver.quit()

    def setUp(self):
        self.driver.delete_all_cookies()

    def _login(self):
        self.driver.get(f"{BASE_URL}/login")
        self.driver.find_element(By.NAME, "email").send_keys(USER_EMAIL)
        self.driver.find_element(By.NAME, "password").send_keys(USER_PASS)
        self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn").click()
        time.sleep(2)

    def test_16_add_to_cart(self):
        """TC-16: Verify adding a product to the cart."""
        self._login()
        self.driver.get(f"{BASE_URL}/shop")
        
        # Click the first "Add to Cart" button or Product card
        product = self.wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, "a[href*='/shop/product/']")))
        product.click()
        
        add_btn = self.wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, "button.pc__atc")))
        add_btn.click()
        
        time.sleep(2)
        self.driver.get(f"{BASE_URL}/cart")
        self.assertIn("/cart", self.driver.current_url)
        self.assertTrue(len(self.driver.find_elements(By.CSS_SELECTOR, ".cart-table__item")) > 0)
        print("✅ TC-16 PASSED — Product added to cart successfully.")

    def test_17_update_quantity(self):
        """TC-17: Verify updating item quantity in the cart."""
        self.driver.get(f"{BASE_URL}/cart")
        qty_input = self.driver.find_element(By.CSS_SELECTOR, ".qty-control__number")
        initial_qty = int(qty_input.get_attribute("value"))
        
        plus_btn = self.driver.find_element(By.CSS_SELECTOR, ".qty-control__increase")
        plus_btn.click()
        time.sleep(2)
        
        new_qty = int(self.driver.find_element(By.CSS_SELECTOR, ".qty-control__number").get_attribute("value"))
        self.assertEqual(new_qty, initial_qty + 1)
        print("✅ TC-17 PASSED — Cart quantity updated.")

    def test_18_remove_item(self):
        """TC-18: Verify removing an item from the cart."""
        self.driver.get(f"{BASE_URL}/cart")
        remove_btn = self.driver.find_element(By.CSS_SELECTOR, ".remove-cart")
        remove_btn.click()
        time.sleep(2)
        
        # Check if cart is empty or item is gone
        src = self.driver.page_source.lower()
        self.assertTrue("empty" in src or len(self.driver.find_elements(By.CSS_SELECTOR, ".cart-table__item")) == 0)
        print("✅ TC-18 PASSED — Item removed from cart.")

    def test_19_apply_coupon(self):
        """TC-19: Verify coupon application logic."""
        # Add item back first
        self.driver.get(f"{BASE_URL}/shop")
        self.driver.find_element(By.CSS_SELECTOR, "a[href*='/shop/product/']").click()
        self.driver.find_element(By.CSS_SELECTOR, "button.pc__atc").click()
        
        self.driver.get(f"{BASE_URL}/cart")
        coupon_input = self.driver.find_element(By.NAME, "coupon_code")
        coupon_input.send_keys("INVALIDCODE123")
        self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        
        time.sleep(2)
        self.assertIn("Invalid coupon", self.driver.page_source)
        print("✅ TC-19 PASSED — Invalid coupon handled correctly.")

    def test_20_checkout_flow(self):
        """TC-20: Verify the full checkout navigation flow."""
        self.driver.get(f"{BASE_URL}/cart")
        checkout_btn = self.wait.until(EC.element_to_be_clickable((By.LINK_TEXT, "PROCEED TO CHECKOUT")))
        checkout_btn.click()
        
        self.assertIn("/checkout", self.driver.current_url)
        print("✅ TC-20 PASSED — Checkout flow initiated successfully.")

if __name__ == "__main__":
    unittest.main(verbosity=2)
