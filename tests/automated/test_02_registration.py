import time
import random
import string
import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options

BASE_URL = "http://localhost:8000"
EXISTING_EMAIL = "user@gmail.com"


def random_string(length=8):
    return ''.join(random.choices(string.ascii_lowercase + string.digits, k=length))


class TestRegistrationFunctionality(unittest.TestCase):

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

    def _go_to_register(self):
        self.driver.get(f"{BASE_URL}/register")
        self.wait.until(EC.presence_of_element_located((By.NAME, "name")))

    def _logout_if_needed(self):
        try:
            self.driver.get(BASE_URL)
            logout_form = self.driver.find_elements(By.CSS_SELECTOR, "form[action*='logout']")
            if logout_form:
                logout_form[0].submit()
                time.sleep(1)
        except Exception:
            pass

    def _fill_registration_form(self, name, email, mobile, password, password_confirm):
        fields = {
            "name": name,
            "email": email,
            "mobile": mobile,
            "password": password,
            "password_confirmation": password_confirm,
        }
        for field_name, value in fields.items():
            element = self.driver.find_element(By.NAME, field_name)
            element.clear()
            element.send_keys(value)

    def test_06_successful_registration(self):
        self._logout_if_needed()
        self._go_to_register()

        unique = random_string(6)
        self._fill_registration_form(
            name=f"Test User {unique}",
            email=f"test_{unique}@abacart.com",
            mobile=f"09{random.randint(100000000, 999999999)}",
            password="Password123!",
            password_confirm="Password123!",
        )

        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()
        time.sleep(3)

        self.assertNotIn("/register", self.driver.current_url,
                         "FAIL: User was not redirected after successful registration.")
        print("[PASS] TC-06 PASSED — Successful registration with valid data.")

    def test_07_duplicate_email(self):
        self._logout_if_needed()
        self._go_to_register()

        self._fill_registration_form(
            name="Duplicate Test",
            email=EXISTING_EMAIL,
            mobile=f"09{random.randint(100000000, 999999999)}",
            password="Password123!",
            password_confirm="Password123!",
        )

        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()
        time.sleep(2)

        self.assertIn("/register", self.driver.current_url,
                      "FAIL: Duplicate email was accepted.")

        page_source = self.driver.page_source.lower()
        has_error = ("already been taken" in page_source or
                     "has-error" in page_source or
                     "invalid-feedback" in page_source)
        self.assertTrue(has_error,
                        "FAIL: No error message for duplicate email.")
        print("✅ TC-07 PASSED — Duplicate email correctly rejected.")

    def test_08_invalid_mobile_format(self):
        self._logout_if_needed()
        self._go_to_register()

        unique = random_string(6)
        self._fill_registration_form(
            name=f"Bad Mobile {unique}",
            email=f"badmobile_{unique}@abacart.com",
            mobile="12345",
            password="Password123!",
            password_confirm="Password123!",
        )

        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()
        time.sleep(2)

        self.assertIn("/register", self.driver.current_url,
                      "FAIL: Invalid mobile format was accepted.")

        page_source = self.driver.page_source.lower()
        has_error = ("mobile" in page_source and
                     ("must start" in page_source or
                      "invalid" in page_source or
                      "has-error" in page_source or
                      "invalid-feedback" in page_source))
        self.assertTrue(has_error,
                        "FAIL: No validation error for invalid mobile format.")
        print("✅ TC-08 PASSED — Invalid mobile number format rejected.")

    def test_09_password_mismatch(self):
        self._logout_if_needed()
        self._go_to_register()

        unique = random_string(6)
        self._fill_registration_form(
            name=f"Mismatch {unique}",
            email=f"mismatch_{unique}@abacart.com",
            mobile=f"09{random.randint(100000000, 999999999)}",
            password="Password123!",
            password_confirm="DifferentPassword!",
        )

        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()
        time.sleep(2)

        self.assertIn("/register", self.driver.current_url,
                      "FAIL: Mismatched passwords were accepted.")

        page_source = self.driver.page_source.lower()
        has_error = ("confirmation" in page_source or
                     "do not match" in page_source or
                     "has-error" in page_source)
        self.assertTrue(has_error,
                        "FAIL: No error message for password mismatch.")
        print("✅ TC-09 PASSED — Password mismatch correctly rejected.")

    def test_10_short_password(self):
        self._logout_if_needed()
        self._go_to_register()

        unique = random_string(6)
        self._fill_registration_form(
            name=f"Short PW {unique}",
            email=f"shortpw_{unique}@abacart.com",
            mobile=f"09{random.randint(100000000, 999999999)}",
            password="abc",
            password_confirm="abc",
        )

        submit_btn = self.driver.find_element(By.CSS_SELECTOR, "button.auth-submit-btn")
        submit_btn.click()
        time.sleep(2)

        self.assertIn("/register", self.driver.current_url,
                      "FAIL: Short password was accepted.")

        page_source = self.driver.page_source.lower()
        has_error = ("at least" in page_source or
                     "8 character" in page_source or
                     "has-error" in page_source)
        self.assertTrue(has_error,
                        "FAIL: No error message for short password.")
        print("✅ TC-10 PASSED — Short password correctly rejected.")


if __name__ == "__main__":
    unittest.main(verbosity=2)
