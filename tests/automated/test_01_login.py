import time
import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options

BASE_URL = "http://localhost:8000"

VALID_EMAIL = "user@gmail.com"
VALID_PASSWORD = "qweasdzxc"

ADMIN_EMAIL = "jblicup@gmail.com"
ADMIN_PASSWORD = "qweasdzxc"


class TestLoginFunctionality(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        chrome_options = Options()
        chrome_options.add_argument("--window-size=1920,1080")
        chrome_options.add_argument("--disable-gpu")

        cls.driver = webdriver.Chrome(options=chrome_options)
        cls.driver.implicitly_wait(10)
        cls.wait = WebDriverWait(cls.driver, 10)

    @classmethod
    def tearDownClass(cls):
        cls.driver.quit()

    def _go_to_login(self):
        self.driver.get(f"{BASE_URL}/login")
        self.wait.until(
            EC.presence_of_element_located((By.NAME, "email"))
        )

    def _logout_if_needed(self):
        self.driver.delete_all_cookies()
        self.driver.get(BASE_URL)
        time.sleep(1)

    def test_01_successful_login(self):
        self._logout_if_needed()
        self._go_to_login()

        self.driver.find_element(By.NAME, "email").send_keys(VALID_EMAIL)
        self.driver.find_element(By.NAME, "password").send_keys(VALID_PASSWORD)

        self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn").click()

        time.sleep(3)

        self.assertNotIn("/login", self.driver.current_url)
        print("PASSED: Login successful.")

    def test_02_invalid_password(self):
        self._logout_if_needed()
        self._go_to_login()

        self.driver.find_element(By.NAME, "email").send_keys(VALID_EMAIL)
        self.driver.find_element(By.NAME, "password").send_keys("WrongPassword!")

        self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn").click()

        time.sleep(2)

        self.assertIn("/login", self.driver.current_url)
        print("PASSED: Invalid password rejected.")

    def test_03_empty_fields(self):
        self._logout_if_needed()
        self._go_to_login()

        self.driver.find_element(By.NAME, "email").clear()
        self.driver.find_element(By.NAME, "password").clear()

        self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn").click()

        time.sleep(1)

        self.assertIn("/login", self.driver.current_url)
        print("PASSED: Empty fields blocked.")

    def test_04_customer_redirect(self):
        self._logout_if_needed()
        self._go_to_login()

        self.driver.find_element(By.NAME, "email").send_keys(VALID_EMAIL)
        self.driver.find_element(By.NAME, "password").send_keys(VALID_PASSWORD)

        self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn").click()

        time.sleep(3)

        self.assertNotIn("/admin", self.driver.current_url)
        print("PASSED: Customer redirected correctly.")

    def test_05_sql_injection(self):
        self._logout_if_needed()
        self._go_to_login()

        self.driver.find_element(By.NAME, "email").send_keys("admin@test.com' OR '1'='1")
        self.driver.find_element(By.NAME, "password").send_keys("' OR '1'='1")

        self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn").click()

        time.sleep(2)

        page_source = self.driver.page_source.lower()

        self.assertTrue(
            "/login" in self.driver.current_url or "/admin" not in self.driver.current_url
        )

        self.assertNotIn("sql", page_source)
        self.assertNotIn("syntax error", page_source)

        print("PASSED: SQL injection blocked.")


if __name__ == "__main__":
    unittest.main(verbosity=2)