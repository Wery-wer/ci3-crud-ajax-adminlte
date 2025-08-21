<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Date Format Helper - Simplified and Safe Version
 * 
 * Fungsi untuk konversi format tanggal antara display (dd.mm.yyyy) dan database (yyyy-mm-dd)
 */

if (!function_exists('format_date_to_display')) {
    /**
     * Konversi tanggal dari format database (yyyy-mm-dd) ke format display (dd.mm.yyyy)
     */
    function format_date_to_display($date_db) {
        if (empty($date_db) || $date_db === '0000-00-00' || $date_db === '0000-00-00 00:00:00') {
            return null;
        }
        
        $timestamp = strtotime($date_db);
        if ($timestamp === false) {
            return null;
        }
        return date('d.m.Y', $timestamp);
    }
}

if (!function_exists('format_date_to_database')) {
    /**
     * Konversi tanggal dari format display (dd.mm.yyyy) ke format database (yyyy-mm-dd)
     */
    function format_date_to_database($date_display) {
        if (empty($date_display)) {
            return null;
        }
        
        $parts = explode('.', $date_display);
        if (count($parts) != 3) {
            return null;
        }
        
        $day = (int)$parts[0];
        $month = (int)$parts[1];
        $year = (int)$parts[2];
        
        // Validasi tanggal
        if (!checkdate($month, $day, $year)) {
            return null;
        }
        
        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }
}

if (!function_exists('convert_form_dates_to_db')) {
    /**
     * Konversi semua field tanggal dalam data form dari display ke database format
     */
    function convert_form_dates_to_db($data, $date_fields = ['tanggal_lahir', 'tanggalmasuk', 'tanggalkeluar']) {
        if (!is_array($data)) {
            return $data;
        }
        
        foreach ($date_fields as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                $converted = format_date_to_database($data[$field]);
                if ($converted !== null) {
                    $data[$field] = $converted;
                } else {
                    // If conversion fails, remove the field to avoid database errors
                    unset($data[$field]);
                }
            }
        }
        
        return $data;
    }
}

if (!function_exists('format_dates_in_object')) {
    /**
     * Konversi semua field tanggal dalam object dari database ke display format
     */
    function format_dates_in_object($data, $date_fields = ['tanggal_lahir', 'tanggalmasuk', 'tanggalkeluar']) {
        if (!is_object($data) && !is_array($data)) {
            return $data;
        }
        
        foreach ($date_fields as $field) {
            if (is_object($data) && isset($data->$field)) {
                $data->$field = format_date_to_display($data->$field);
            } elseif (is_array($data) && isset($data[$field])) {
                $data[$field] = format_date_to_display($data[$field]);
            }
        }
        
        return $data;
    }
}

if (!function_exists('validate_date_format')) {
    /**
     * Validasi format tanggal dd.mm.yyyy
     */
    function validate_date_format($date) {
        if (empty($date)) {
            return false;
        }
        
        $parts = explode('.', $date);
        if (count($parts) != 3) {
            return false;
        }
        
        $day = (int)$parts[0];
        $month = (int)$parts[1];
        $year = (int)$parts[2];
        
        return checkdate($month, $day, $year);
    }
}