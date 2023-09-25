# Baselinker

Przykładowe skrypty realizujące połączenie PrestaShop z Baselinkerem

# Wyszukiwarka.php

Skrypt wyszukujący wszystkie dane o zamówieniu w Baselinkerze na podstawie numeru zamówienia z PrestaShop. 
Numerem wejściowym może być również numer zamówienia z Baselinkera.

![https://user-images.githubusercontent.com/92076104/210280956-895319f8-e26f-42eb-860b-03ebd4b87369.gif](https://github.com/tommyk012/baselinker/blob/main/baselinker/wyszukiwarka.png)

# Anulowane.php

Skrypt sprawdzający nowe zamówienia anulowane na PrestaShop i ustawiający odpowiedni status w połączonym zamówieniu w Baselinkerze. Informacja o anulowanym zamówieniu wysyłana jest na odpowiedni kanał na Slacku. Skrypt korzysta z dwóch tekstowych plików pomocniczych:
 - anulowane_input.in - lista wszystkich zamówień anulowanych do tej pory
 - log_anulowane.out - log potwierdzający zmianę statusu na BL


