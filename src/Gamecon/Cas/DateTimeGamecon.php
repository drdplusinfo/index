<?php declare(strict_types=1);

namespace DrdPlus\Index\Gamecon\Cas;

class DateTimeGamecon extends DateTimeCz
{
    public static function spocitejZacatekGameconu(int $rok): DateTimeGamecon
    {
        $zacatekCervence               = new static($rok . '-07-01 00:00:00');
        $zacatekTretihoTydneVCervenci  = self::dejZacatekXTydne(3, $zacatekCervence);
        $ctvrtekVeTretimTydnuVCervenci = self::dejDatumDneVTydnuOdData(static::CTVRTEK, $zacatekTretihoTydneVCervenci);
        if ($ctvrtekVeTretimTydnuVCervenci->format('d') >= 15) { // ve třetím týdnu pouze pokud začne v půlce měsíce či později
            return $ctvrtekVeTretimTydnuVCervenci->setTime(7, 0, 0);
        }
        $ctvrtekVeCtvrtemTydnuVCervenci = $ctvrtekVeTretimTydnuVCervenci->modify('+1 week');
        return $ctvrtekVeCtvrtemTydnuVCervenci->setTime(7, 0, 0);
    }

    public static function dejZacatekPredposlednihoTydneVMesici(DateTimeGamecon $datum): DateTimeGamecon
    {
        $posledniDenString = (clone $datum)->format('Y-m-t 00:00:00'); // t je maximum dni v mesici
        $posledniDen       = DateTimeGamecon::createFromFormat('Y-m-d H:i:s', $posledniDenString);
        $predposledniTyden = $posledniDen->modify('-1 week');
        return self::dejDatumDneVTydnuDoData(self::PONDELI, $predposledniTyden);
    }

    public static function spocitejKonecGameconu(int $rok): DateTimeGamecon
    {
        $zacatekGameconu              = self::spocitejZacatekGameconu($rok);
        $prvniNedelePoZacatkuGameconu = self::dejDatumDneVTydnuOdData(static::NEDELE, $zacatekGameconu);

        return $prvniNedelePoZacatkuGameconu->setTime(21, 0, 0);
    }

    protected static function zDbFormatu(string $datum): DateTimeGamecon
    {
        $zacatekGameconu = static::createFromFormat(self::FORMAT_DB, $datum);
        if ($zacatekGameconu) {
            /** @var DateTimeGamecon $zacatekGameconu */
            return $zacatekGameconu;
        }
        throw new \RuntimeException(sprintf("Can not create date from '%s' with expected format '%s'", $datum, self::FORMAT_DB));
    }

    protected static function dejZacatekXTydne(int $poradiTydne, DateTimeGamecon $datum): DateTimeGamecon
    {
        $prvniDenVMesici      = (clone $datum)->setDate((int)$datum->format('Y'), (int)$datum->format('m'), 1);
        $posunTydnu           = $poradiTydne - 1; // prvni tyden uz mame, dalsi posun je bez nej
        $datumSeChtenymTydnem = $prvniDenVMesici->modify("+$posunTydnu weeks");
        return self::dejDatumDneVTydnuDoData(self::PONDELI, $datumSeChtenymTydnem);
    }

    public static function dejDatumDneVTydnuDoData(string $cilovyDenVTydnuDoData, DateTimeGamecon $doData): DateTimeGamecon
    {
        $poradiDneVTydnuDoData   = (int)$doData->format('N');
        $poradiCilovehoDneVTydnu = static::poradiDne($cilovyDenVTydnuDoData);
        $rozdilDni               = $poradiCilovehoDneVTydnu - $poradiDneVTydnuDoData;
        // záporné rozdíly posouvají vzad
        return (clone $doData)->modify("$rozdilDni days");
    }

    public static function dejDatumDneVTydnuOdData(string $cilovyDenVTydnuOdData, DateTimeGamecon $odData): DateTimeGamecon
    {
        $poradiDneVTydnu         = $odData->format('N');
        $poradiCilovehoDneVTydnu = static::poradiDne($cilovyDenVTydnuOdData);
        // například neděle - čtvrtek = 7 - 4 = 3; nebo středa - středa = 3 - 3 = 0; pondělí - středa = 1 - 3 = -2
        $rozdilDni = $poradiCilovehoDneVTydnu - $poradiDneVTydnu;
        if ($rozdilDni < 0) { // chceme den v týdnu před současným, třeba pondělí před středou, ale "až potom", tedy v dalším týdnu
            // $rozdilDni je tady záporný, posuneme to do dalšího týdne
            $rozdilDni = 7 + $rozdilDni; // pondělí - středa = 7 + (1 - 3) = 7 + (-2) = 5 (středa + 5 dní je další pondělí)
        }
        return (clone $odData)->modify("+ $rozdilDni days");
    }

    protected static function naTestuOTydenDriv(DateTimeGamecon $datum): DateTimeGamecon
    {
        if (defined('TESTING') && TESTING) {
            return $datum->modify('-1 week');
        } else {
            return $datum;
        }
    }

    public static function spocitejZacatekRegistraciUcastniku(int $rok): DateTimeGamecon
    {
        $zacatekKvetna               = new static($rok . '-05-01 00:00:00');
        $zacatekTretihoTydneVKvetnu  = self::dejZacatekXTydne(3, $zacatekKvetna);
        $ctvrtekVeTretimTydnuVKvetnu = self::dejDatumDneVTydnuOdData(static::CTVRTEK, $zacatekTretihoTydneVKvetnu);
        [$hodina, $minuta] = str_split((string)$rok, 2); // ciselna hricka, rok 2022 = hodina 20 a minuta 22

        return $ctvrtekVeTretimTydnuVKvetnu->setTime((int)$hodina, (int)$minuta, 0);
    }

    public static function spoctejZacatekPrvniVlnyOd(int $rok): DateTimeGamecon
    {
        return self::spocitejZacatekRegistraciUcastniku($rok)->modify('+1 week');
    }

    public static function spocitejPrvniHromadneOdhlasovaniOd(int $rok)
    {
        // konec června
        return new static($rok . '-06-30 23:59:00');
    }

    public static function spocitejDruheHromadneOdhlasovaniOd(int $rok): DateTimeGamecon
    {
        $zacatekGameconu            = self::spocitejZacatekGameconu($rok);
        $nedeleNaKonciGameconu      = self::dejDatumDneVTydnuDoData(self::NEDELE, $zacatekGameconu);
        $nedelePredZacatkemGameconu = $nedeleNaKonciGameconu->modify('-1 week');

        return $nedelePredZacatkemGameconu->setTime(23, 59, 00);
    }

}
