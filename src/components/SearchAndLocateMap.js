import React, { useRef, useState } from 'react';
import { MapContainer, TileLayer, Marker, Popup, useMap } from 'react-leaflet';
import { OpenStreetMapProvider, GeoSearchControl } from 'leaflet-geosearch';
import 'leaflet-geosearch/dist/geosearch.css';
import 'leaflet/dist/leaflet.css';
import './App.css'; // Ajoutez votre propre fichier CSS pour personnaliser le style de la carte si nécessaire

const SearchAndLocateMap = () => {
  const [position, setPosition] = useState(null);
  const mapRef = useRef();

  // Fonction pour centrer la carte sur la position actuelle de l'utilisateur
  const locateUser = () => {
    mapRef.current.locate();
  };

  // Composant pour gérer le centrage de la carte lors de la localisation
  const LocationMarker = () => {
    const map = useMap();

    map.on('locationfound', (e) => {
      setPosition(e.latlng);
      map.setView(e.latlng, map.getZoom());
    });

    return position === null ? null : (
      <Marker position={position}>
        <Popup>Vous êtes ici</Popup>
      </Marker>
    );
  };

  // Composant de recherche
  const SearchComponent = () => {
    const provider = new OpenStreetMapProvider();
    const searchControl = new GeoSearchControl({
      provider,
      style: 'bar',
      showMarker: true,
      showPopup: false,
      autoClose: true,
    });

    useMap(map => {
      map.addControl(searchControl);
      return () => map.removeControl(searchControl);
    });

    return null;
  };

  return (
    <div className="map-container">
      <MapContainer
        center={[48.8566, 2.3522]} // Coordonnées de Paris (centre de la carte par défaut)
        zoom={13} // Niveau de zoom par défaut
        ref={mapRef}
      >
        <TileLayer
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
          attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        />
        <LocationMarker />
        <SearchComponent />
      </MapContainer>

      <button className="locate-button" onClick={locateUser}>
        Localiser moi
      </button>
    </div>
  );
};

export default SearchAndLocateMap;
