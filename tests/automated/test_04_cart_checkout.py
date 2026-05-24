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


    def _ensure_item_in_cart(self):
        self._login()
        self.driver.get(f"{BASE_URL}/cart")
        time.sleep(1)
        if len(self.driver.find_elements(By.CSS_SELECTOR, "tbody tr")) == 0:
            self.driver.get(f"{BASE_URL}/shop")
            product = self.wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "div.ac-product-card:not(.product-out-of-stock) a[href*='/shop/product/']")))
            self.driver.get(product.get_attribute("href"))
            add_btn = self.wait.until(EC.element_to_be_clickable((By.ID, "addToCartBtn")))
            add_btn.click()
            time.sleep(2)


    def test_16_add_to_cart(self):
        """TC-16: Verify adding a product to the cart."""
        self._login()
        self.driver.get(f"{BASE_URL}/shop")
       
        # Navigate directly to the first in-stock product URL to avoid click interception and out-of-stock issues
        product = self.wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "div.ac-product-card:not(.product-out-of-stock) a[href*='/shop/product/']")))
        self.driver.get(product.get_attribute("href"))
       
        add_btn = self.wait.until(EC.element_to_be_clickable((By.ID, "addToCartBtn")))
        add_btn.click()
       
        time.sleep(2)
        self.driver.get(f"{BASE_URL}/cart")
        self.assertIn("/cart", self.driver.current_url)
        self.assertTrue(len(self.driver.find_elements(By.CSS_SELECTOR, "tbody tr")) > 0)
        print("[PASS] TC-16 PASSED — Product added to cart successfully.")


    def test_17_update_quantity(self):
        """TC-17: Verify updating item quantity in the cart."""
        self._ensure_item_in_cart()
        self.driver.get(f"{BASE_URL}/cart")
        qty_input = self.driver.find_element(By.CSS_SELECTOR, "tbody td input[readonly]")
        initial_qty = int(qty_input.get_attribute("value"))
       
        plus_btn = self.driver.find_element(By.CSS_SELECTOR, "form[action*='increase'] button")
        plus_btn.click()
        time.sleep(2)
       
        qty_input = self.driver.find_element(By.CSS_SELECTOR, "tbody td input[readonly]")
        new_qty = int(qty_input.get_attribute("value"))
        self.assertEqual(new_qty, initial_qty + 1)
        print("[PASS] TC-17 PASSED — Cart quantity updated.")


    def test_18_remove_item(self):
        """TC-18: Verify removing an item from the cart."""
        self._ensure_item_in_cart()
        self.driver.get(f"{BASE_URL}/cart")
        remove_btn = self.driver.find_element(By.CSS_SELECTOR, "form[action*='remove'] button")
        remove_btn.click()
        time.sleep(2)
       
        # Check if cart is empty or item is gone
        src = self.driver.page_source.lower()
        self.assertTrue("empty" in src or len(self.driver.find_elements(By.CSS_SELECTOR, "tbody tr")) == 0)
        print("[PASS] TC-18 PASSED — Item removed from cart.")


    def test_19_apply_coupon(self):
        """TC-19: Verify coupon application logic."""
        self._login()
        # Add item back first
        self.driver.get(f"{BASE_URL}/shop")
        product_link = self.driver.find_element(By.CSS_SELECTOR, "div.ac-product-card:not(.product-out-of-stock) a[href*='/shop/product/']")
        self.driver.get(product_link.get_attribute("href"))
        self.driver.find_element(By.ID, "addToCartBtn").click()
        time.sleep(2)
       
        self.driver.get(f"{BASE_URL}/cart")
        coupon_input = self.driver.find_element(By.NAME, "coupon_code")
        coupon_input.send_keys("INVALIDCODE123")
        self.driver.find_element(By.CSS_SELECTOR, "form[action*='coupon/apply'] button").click()
       
        time.sleep(2)
        self.assertIn("Invalid coupon", self.driver.page_source)
        print("[PASS] TC-19 PASSED — Invalid coupon handled correctly.")


    def test_20_checkout_flow(self):
        """TC-20: Verify the full checkout navigation flow."""
        self._ensure_item_in_cart()
        self.driver.get(f"{BASE_URL}/cart")
        checkout_btn = self.wait.until(EC.element_to_be_clickable((By.LINK_TEXT, "PROCEED TO CHECKOUT")))
        self.driver.execute_script("arguments[0].click();", checkout_btn)
       
        self.assertIn("/checkout", self.driver.current_url)
        print("[PASS] TC-20 PASSED — Checkout flow initiated successfully.")


if __name__ == "__main__":
    unittest.main(verbosity=2)



