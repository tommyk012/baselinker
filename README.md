# Baselinker

Przykładowe skrypty realizujące połączenie PrestaShop z Baselinkerem

# Wyszukiwarka.php

Skrypt wyszukujący wszystkie dane o zamówieniu w Baselinkerze na podstawie numeru zamówienia z PrestaShop. 
Numerem wejściowym może być również numer zamówienia z Baselinkera.

# Anulowane.php

Skrypt sprawdzający nowe zamówienia anulowane na PrestaShop i ustawiający odpowiedni status w połączonym zamówieniu w Baselinkerze. Informacja o anulowanym zamówieniu wysyłana jest na odpowiedni kanał na Slacku. Skrypt korzysta z dwóch tesktowych plików pomocniczych:
 - anulowane_input.in - lista wszystkich zamówień anulowanych do tej pory
 - log_anulowane.out - log potwierdzający zmianę statusu na BL


