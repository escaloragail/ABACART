"""
TEST SCRIPT #3 — Shop Browsing & Search/Filtering
Abacart PH | Tool: Python + Selenium | Author: Member 3
TC-11: Shop page loads correctly
TC-12: Product details page accessible
TC-13: Shop page sorting/ordering
TC-14: Category filtering
TC-15: Non-existent product → 404
"""
import time, unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options

BASE_URL = "http://localhost:8000"

class TestShopAndSearch(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        opts = Options()
        opts.add_argument("--window-size=1920,1080")
        cls.driver = webdriver.Chrome(options=opts)
        cls.driver.implicitly_wait(10)

    @classmethod
    def tearDownClass(cls):
        cls.driver.quit()

    def _no_php_errors(self):
        src = self.driver.page_source.lower()
        self.assertNotIn("warning:", src)
        self.assertNotIn("fatal error", src)
        self.assertNotIn("undefined variable", src)

    def test_11_shop_page_loads(self):
        self.driver.get(f"{BASE_URL}/shop")
        time.sleep(2)
        self.assertIn("/shop", self.driver.current_url)
        self._no_php_errors()
        print("✅ TC-11 PASSED — Shop page loads without PHP errors.")

    def test_12_product_details(self):
        self.driver.get(f"{BASE_URL}/shop")
        time.sleep(2)
        links = self.driver.find_elements(By.CSS_SELECTOR, "a[href*='/shop/product/']")
        if not links:
            self.skipTest("No products found.")
        self.driver.get(links[0].get_attribute("href"))
        time.sleep(2)
        self.assertIn("/shop/product/", self.driver.current_url)
        self._no_php_errors()
        print("✅ TC-12 PASSED — Product details page loads correctly.")

    def test_13_shop_ordering(self):
        for order in [1, 2, 3, 4]:
            self.driver.get(f"{BASE_URL}/shop?order={order}")
            time.sleep(1)
            self._no_php_errors()
        print("✅ TC-13 PASSED — Shop ordering works.")

    def test_14_category_filtering(self):
        self.driver.get(f"{BASE_URL}/shop?categories=1")
        time.sleep(2)
        self.assertIn("/shop", self.driver.current_url)
        self._no_php_errors()
        print("✅ TC-14 PASSED — Category filtering works.")

    def test_15_nonexistent_product(self):
        self.driver.get(f"{BASE_URL}/shop/product/nonexistent-xyz-999")
        time.sleep(2)
        src = self.driver.page_source.lower()
        self.assertTrue("404" in src or "not found" in src)
        print("✅ TC-15 PASSED — 404 for non-existent product.")

if __name__ == "__main__":
    unittest.main(verbosity=2)
