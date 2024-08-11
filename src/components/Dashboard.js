import React, { useState, useEffect, useCallback } from 'react';
import { MapContainer, TileLayer, WMSTileLayer, Marker, Popup } from 'react-leaflet';
import 'leaflet/dist/leaflet.css';
import { Container, Grid, Paper, Typography, FormControl, InputLabel, Select, MenuItem, Checkbox, FormControlLabel } from '@mui/material';
import axios from 'axios';
import L from 'leaflet';
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

// Configuration des icônes Leaflet
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
  iconRetinaUrl: markerIcon2x,
  iconUrl: markerIcon,
  shadowUrl: markerShadow,
});

const Dashboard = () => {
  const [selectedLayers, setSelectedLayers] = useState({
    route: true,
    tana: false,
    batiment: false,
  });

  const [dangerLevel, setDangerLevel] = useState('');
  const [inondations, setInondations] = useState([]);
  const [spatialData, setSpatialData] = useState(null);

  // Charger les inondations depuis Laravel
  useEffect(() => {
    fetchInondations();
  }, []);

  const fetchInondations = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/tana-inonder');
      console.log('Données reçues :', response.data);
      setInondations(response.data);
    } catch (error) {
      console.error('Erreur lors de la récupération des données:', error);
    }
  };

  // Charger les données spatiales depuis GeoServer avec filtre sur le niveau de danger
  const fetchSpatialData = useCallback(async () => {
    const wfsUrl = 'http://localhost:8080/geoserver/innondation/wfs';
    const params = {
      service: 'WFS',
      version: '1.1.0',
      request: 'GetFeature',
      typename: 'innondation:tana_inonder_bd',
      outputFormat: 'application/json',
      cql_filter: dangerLevel ? `cl_danger >= ${dangerLevel}` : '',
    };

    try {
      const response = await axios.get(wfsUrl, { params });
      setSpatialData(response.data.features);
    } catch (error) {
      console.error('Erreur lors de la récupération des données spatiales:', error);
    }
  }, [dangerLevel]);

  useEffect(() => {
    fetchSpatialData();
  }, [fetchSpatialData]);

  // Gérer le changement de niveau de danger
  const handleDangerLevelChange = (event) => {
    setDangerLevel(event.target.value);
  };

  // Gérer le changement d'état des couches sélectionnées
  const handleLayerChange = (layerName) => {
    setSelectedLayers({
      ...selectedLayers,
      [layerName]: !selectedLayers[layerName],
    });
  };

  return (
    <div>
      <div>
        <FormControl>
          <InputLabel>Niveau de danger</InputLabel>
          <Select
            value={dangerLevel}
            onChange={handleDangerLevelChange}
          >
            <MenuItem value="">Tous</MenuItem>
            <MenuItem value="0">Aucun danger</MenuItem>
            <MenuItem value="1">Peu de danger</MenuItem>
            <MenuItem value="2">Danger modéré</MenuItem>
            <MenuItem value="3">Danger élevé</MenuItem>
          </Select>
        </FormControl>
        <FormControlLabel
          control={<Checkbox checked={selectedLayers.route} onChange={() => handleLayerChange('route')} />}
          label="Route"
        />
        <FormControlLabel
          control={<Checkbox checked={selectedLayers.tana} onChange={() => handleLayerChange('tana')} />}
          label="Zone Tana Inonder"
        />
        <FormControlLabel
          control={<Checkbox checked={selectedLayers.batiment} onChange={() => handleLayerChange('batiment')} />}
          label="Bâtiment Inonder"
        />
      </div>

      <Container maxWidth="lg" style={{ marginTop: '20px' }}>
        <Grid container spacing={3}>
          <Grid item xs={12}>
            <Paper>
              <Typography variant="h6" gutterBottom>
                Carte
              </Typography>
              <MapContainer center={[-18.8792, 47.5079]} zoom={12} style={{ height: '600px', width: '100%' }}>
                <TileLayer
                  url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                  attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                />
                {inondations && inondations.length > 0 && inondations.map((inondation) => (
                  <Marker key={inondation.id} position={[
                    inondation.geom && inondation.geom.coordinates[1], 
                    inondation.geom && inondation.geom.coordinates[0]
                  ]}>
                    <Popup>
                      <div>
                        <h3>{inondation.region}</h3>
                        <p>Fokontany: {inondation.fokontany}</p>
                        <p>Niveau de danger: {inondation.cl_danger}</p>
                      </div>
                    </Popup>
                  </Marker>
                ))}
                {selectedLayers.route && (
                  <WMSTileLayer
                    url="http://localhost:8080/geoserver/innondation/wms"
                    layers="innondation:route_tana_inonder"
                    format="image/png"
                    transparent={true}
                    version="1.1.0"
                    crs={L.CRS.EPSG4326}
                  />
                )}
                {selectedLayers.tana && spatialData && (
                  <WMSTileLayer
                    url="http://localhost:8080/geoserver/innondation/wms"
                    layers="innondation:tana_inonder_bd"
                    format="image/png"
                    transparent={true}
                    version="1.1.0"
                    crs={L.CRS.EPSG4326}
                    CQL_FILTER={dangerLevel ? `cl_danger >= ${dangerLevel}` : ""}
                  />
                )}
                {selectedLayers.batiment && spatialData && (
                  <WMSTileLayer
                    url="http://localhost:8080/geoserver/innondation/wms"
                    layers="innondation:batiment_inonder"
                    format="image/png"
                    transparent={true}
                    version="1.1.0"
                    crs={L.CRS.EPSG4326}
                    CQL_FILTER={dangerLevel ? `cl_danger >= ${dangerLevel}` : ""}
                  />
                )}
              </MapContainer>
            </Paper>
          </Grid>
        </Grid>
      </Container>
    </div>
  );
};

export default Dashboard;
