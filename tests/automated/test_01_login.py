"""
=============================================================================
  TEST SCRIPT #1 — Login Functionality
  Abacart PH Automated Testing
  Tool: Python + Selenium WebDriver
  Author: Member 1
=============================================================================
  Covers:
    TC-01: Successful login with valid credentials
    TC-02: Failed login with invalid password
    TC-03: Failed login with empty fields (input validation)
    TC-04: Verify redirect behavior after successful login
    TC-05: SQL Injection attempt on login form
=============================================================================
"""

import time
import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options

# ── Configuration ──
BASE_URL = "http://localhost:8000"
VALID_EMAIL = "user@gmail.com"       # Replace with an actual test account
VALID_PASSWORD = "qweasdzxc"              # Replace with the actual password
ADMIN_EMAIL = "jblicup@gmail.com"           # Replace with an actual admin account
ADMIN_PASSWORD = "qweasdzxc"               # Replace with the actual admin password


class TestLoginFunctionality(unittest.TestCase):
    """Automated test suite for Abacart PH Login Page."""

    @classmethod
    def setUpClass(cls):
        """Initialize the browser once for all tests."""
        chrome_options = Options()
        # chrome_options.add_argument("--headless")  # Uncomment for headless mode
        chrome_options.add_argument("--window-size=1920,1080")
        chrome_options.add_argument("--disable-gpu")
        cls.driver = webdriver.Chrome(options=chrome_options)
        cls.driver.implicitly_wait(10)
        cls.wait = WebDriverWait(cls.driver, 10)

    @classmethod
    def tearDownClass(cls):
        """Close the browser after all tests."""
        cls.driver.quit()

    def _go_to_login(self):
        """Helper: navigate to the login page."""
        self.driver.get(f"{BASE_URL}/login")
        self.wait.until(EC.presence_of_element_located((By.NAME, "email")))

    def _logout_if_needed(self):
        """Helper: clear cookies and refresh to ensure a fresh session."""
        self.driver.delete_all_cookies()
        self.driver.get(BASE_URL)
        time.sleep(1)

    # ──────────────────────────────────────────────
    # TC-01: Successful login with valid credentials
    # ──────────────────────────────────────────────
    def test_01_successful_login(self):
        """Verify that a user can log in with valid email and password."""
        self._logout_if_needed()
        self._go_to_login()

        # Fill in the form
        email_field = self.driver.find_element(By.NAME, "email")
        password_field = self.driver.find_element(By.NAME, "password")

        email_field.clear()
        email_field.send_keys(VALID_EMAIL)
        password_field.clear()
        password_field.send_keys(VALID_PASSWORD)

        # Click "Log In"
        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()

        # Wait for redirect — should NOT stay on /login
        time.sleep(3)
        current_url = self.driver.current_url

        self.assertNotIn("/login", current_url,
                         "User was not redirected after valid login.")
        print("Successful login with valid credentials.")

    # ──────────────────────────────────────────────
    # TC-02: Failed login with invalid password
    # ──────────────────────────────────────────────
    def test_02_invalid_password(self):
        """Verify that login fails with an incorrect password."""
        self._logout_if_needed()
        self._go_to_login()

        email_field = self.driver.find_element(By.NAME, "email")
        password_field = self.driver.find_element(By.NAME, "password")

        email_field.clear()
        email_field.send_keys(VALID_EMAIL)
        password_field.clear()
        password_field.send_keys("WrongPassword999!")

        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()

        time.sleep(2)

        # Should remain on /login and show an error
        self.assertIn("/login", self.driver.current_url,
                      "User was redirected despite invalid password.")

        # Check for validation error message
        page_source = self.driver.page_source.lower()
        has_error = ("invalid" in page_source or
                     "credentials" in page_source or
                     "do not match" in page_source or
                     "invalid-feedback" in page_source)
        self.assertTrue(has_error,
                        "No error message shown for invalid credentials.")
        print("Invalid password correctly rejected.")

    # ──────────────────────────────────────────────
    # TC-03: Empty fields validation
    # ──────────────────────────────────────────────
    def test_03_empty_fields(self):
        """Verify that submitting empty login form is prevented by HTML5 validation."""
        self._logout_if_needed()
        self._go_to_login()

        email_field = self.driver.find_element(By.NAME, "email")
        password_field = self.driver.find_element(By.NAME, "password")

        email_field.clear()
        password_field.clear()

        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()

        time.sleep(1)

        # HTML5 'required' attribute should prevent submission — URL stays at /login
        self.assertIn("/login", self.driver.current_url,
                      "Empty form submission was not prevented.")

        # Verify 'required' attribute exists on both fields
        email_required = email_field.get_attribute("required")
        password_required = password_field.get_attribute("required")
        self.assertIsNotNone(email_required, "Email field missing 'required' attribute.")
        self.assertIsNotNone(password_required, "Password field missing 'required' attribute.")
        print("Empty field validation works correctly.")

    # ──────────────────────────────────────────────
    # TC-04: Redirect behavior (customer vs admin)
    # ──────────────────────────────────────────────
    def test_04_customer_redirect(self):
        """Verify that a regular customer is redirected to the homepage after login."""
        self._logout_if_needed()
        self._go_to_login()

        email_field = self.driver.find_element(By.NAME, "email")
        password_field = self.driver.find_element(By.NAME, "password")

        email_field.clear()
        email_field.send_keys(VALID_EMAIL)
        password_field.clear()
        password_field.send_keys(VALID_PASSWORD)

        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()

        time.sleep(3)

        # Regular customer → homepage (/)
        current_url = self.driver.current_url
        self.assertNotIn("/admin", current_url,
                         "Regular user was redirected to admin page.")
        print("Customer correctly redirected to homepage.")

    # ──────────────────────────────────────────────
    # TC-05: SQL Injection attempt
    # ──────────────────────────────────────────────
    def test_05_sql_injection(self):
        """Verify the login form is protected against basic SQL injection."""
        self._logout_if_needed()
        self._go_to_login()

        email_field = self.driver.find_element(By.NAME, "email")
        password_field = self.driver.find_element(By.NAME, "password")

        # Classic SQL injection payload
        email_field.clear()
        email_field.send_keys("admin@test.com' OR '1'='1")
        password_field.clear()
        password_field.send_keys("' OR '1'='1")

        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()

        time.sleep(2)

        # Should NOT grant access
        page_source = self.driver.page_source.lower()
        is_still_login = "/login" in self.driver.current_url
        no_admin_access = "/admin" not in self.driver.current_url

        self.assertTrue(is_still_login or no_admin_access,
                        "SQL injection may have bypassed authentication!")

        # Check no PHP/SQL error is exposed
        self.assertNotIn("sql", page_source, "SQL error exposed in page source.")
        self.assertNotIn("syntax error", page_source, "Syntax error exposed.")
        print("SQL injection attempt correctly rejected.")


if __name__ == "__main__":
    unittest.main(verbosity=2)
