#1
SELECT SUM(Z.Kwota), K.Miasto
FROM Zamowienia Z
         LEFT JOIN Klienci K ON K.NrKlienta = Z.NrKlienta
WHERE Z.DataZaplaty IS NOT NULL
GROUP BY K.Miasto;

#2
SELECT SUM(Z.Kwota), K.Miasto, DATE_FORMAT(Z.DataZlozenia, '%Y-%m') as Miesiac
FROM Zamowienia Z
         LEFT JOIN Klienci K ON K.NrKlienta = Z.NrKlienta
WHERE Z.DataZaplaty IS NOT NULL
GROUP BY YEAR(Z.DataZlozenia), MONTH(Z.DataZlozenia), K.Miasto;
