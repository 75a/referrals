<?php

namespace app\locales;

use app\core\Language;

class Polish extends Language
{
    public static array $texts;

    public static function getTexts(): array
    {
        return [
            "Referral Script" => "Aplikacja Referral",
            "Language" => "Język",
            "Welcome" => "Witaj",
            "Home" => "Strona główna",
            "Login" => "Zaloguj się",
            "Register" => "Zarejestruj się",
            "Logout" => "Wyloguj się",
            "Profile" => "Profil",
            "Contact" => "Kontakt",
            "You are not logged in" => "Nie jesteś zalogowany",
            "You are logged in as" => "Jesteś zalogowany jako",
            "Michal Brzozowski 2020" => "Michał Brzozowski 2020",
            "Info" => "Informacja",
            "You dont have permission to access this page" => "Nie masz uprawnień aby wyświetlić tę stronę",
            "Not found" => "Nie znaleziono",
            "This page is available only for the guest users" => "Ta strona jest dostępna tylko dla gości",
            "Contact us" => "Skontaktuj się z nami",
            "Submit" => "Wyślij",
            "Enter your subject" => "Wprowadź nazwę tematu",
            "Your email" => "Twój email",
            "Body" => "Treść",
            "Password" => "Hasło",
            "Repeat password" => "Powtórz hasło",
            "Please log in!" => "Prosimy o zalogowanie się!",
            "Your e-mail" => "Twój e-mail",
            "Your name" => "Twoja nazwa",
            "Your reflink" => "Twój reflink",
            "Your points" => "Twoje punkty",
            "First name" => "Imię",
            "Last name" => "Nazwisko",
            "Create an account" => "Utwórz konto",
            "Welcome to the home page!" => "Witaj na stronie głównej!",
            "This field is required" => "To pole jest wymagane",
            "Min length of this field must be {min}" => "Minimalna długość tego pola to {min}",
            "Max length of this field must be {max}" => "Maksymalna długość tego pola to {max}",
            "This field must be valid email address" => "Należy podać prawidłowy adres e-mail",
            "This field must be the same as {match}" => "To pole musi być identyczne z {match}",
            "Record with this {field} already exists" => "Ta wartość '{field}' istnieje już w bazie danych",
            "This e-mail is not registered" => "Ten e-mail nie jest zarejestrowany",
            "Password is incorrect" => "Hasło jest nieprawidłowe",
            "Someone just got points" => "Ktoś dostał punkty",
            "This referral link has already been used" => "Ten link został już użyty",
            "This referral link is invalid" => "Ten link jest nieprawidłowy",
            "Thanks for contacting us." => "Dziękujemy za skontaktowanie się z nami",
            "Thanks for registering" => "Dziękujemy za rejestracje",
            "Logged in successfully!" => "Zalogowano pomyślnie!",
            "You have been logged out" => "Zostałeś wylogowany",
            "You will get a point for every click on your dedicated referral link." => "Otrzymasz punkt za każde kliknięcie na twój dedykowany link.",
            "Your link is presented below" => "Twój link jest zaprezentowany poniżej",
            "Account status" => "Status konta",
            "Status 0" => "Nieaktywne",
            "Status 1" => "Aktywne",
            "Please click on the confirmation link we've sent you to your e-mail" => "Prosimy o kliknięcie w link potwierdzający który wysłaliśmy na twój adres e-mail",
            "Your account has been activated!" => "Twoje konto zostało aktywowane!",

         ];
    }
}