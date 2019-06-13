package com.itakademy.grandlyon.model

import java.util.*

class Poi(
    val id : Int,
    val id_sitra1 : String,
    val type: PoiType,
    val type_detail: String,
    val name: String,
    val address: String,
    val zip_code: Int?,
    val town: String,
    val phone: String,
    val fax: String,
    val fax_phone: String,
    val email: String,
    val website: String,
    val facebook: String,
    val rank: Int?,
    val opening_times: String,
    val price: String,
    val pricemin: Float?,
    val pricemax: Float?,
    val author: String,
    val gid: Int?,
    val creation_date: Date?,
    val last_update: Date?,
    val last_update_fme: Date?,
    val geometry: Geometry?
)

@Suppress("SpellCheckingInspection")
enum class PoiType {
    HEBERGEMENT_LOCATIF,
    PATRIMOINE_CULTUREL,
    RESTAURATION,
    COMMERCE_ET_SERVICE,
    EQUIPEMENT,
    HOTELLERIE,
    DEGUSTATION,
    HOTELLERIE_PLEIN_AIR,
    HEBERGEMENT_COLLECTIF,
    PATRIMOINE_NATURE
}

class Geometry(
    val longitude: Double?,
    val latitude: Double?
)