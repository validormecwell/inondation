import React, { useState, useEffect } from 'react';
import { MapContainer, TileLayer, Polygon, Popup, WMSTileLayer } from 'react-leaflet';
import wellknown from 'wellknown';
import { Container, Grid, Paper, Typography } from '@mui/material';

const MapComponent = () => {
    const [markers, setMarkers] = useState([]);
    const [dangerLevel, setDangerLevel] = useState(0);
    const [selectedLayers, setSelectedLayers] = useState({
        route: false,
        batiment: false,
        sol: false,
    });

    useEffect(() => {
        const fetchMarkers = async () => {
            try {
                const response = await fetch(`http://localhost:8000/api/tana-inonder/markers/${dangerLevel}`);
                if (!response.ok) {
                    throw new Error('Failed to fetch markers');
                }
                const data = await response.json();
                console.log('Markers fetched:', data);
                setMarkers(data);
            } catch (error) {
                console.error('Error fetching markers:', error);
            }
        };

        fetchMarkers();
    }, [dangerLevel]);

    const isValidGeometry = (geometry) => {
        try {
            const geoJson = wellknown.parse(geometry);
            return !!geoJson && !!geoJson.coordinates;
        } catch (error) {
            console.error('Error parsing geometry:', error);
            return false;
        }
    };

    const handleChangeDangerLevel = (e) => {
        const level = parseInt(e.target.value, 10);
        setDangerLevel(level);
    };

    const handleLayerChange = (layer) => {
        setSelectedLayers(prevState => ({
            ...prevState,
            [layer]: !prevState[layer]
        }));
    };

    // Coordonnées d'Antananarivo
    const antananarivoCoordinates = [-18.8792, 47.5079];
    const zoomLevel = 12; // Zoom approprié pour afficher Antananarivo

    return (
        <div>
            <div>
                <label htmlFor="dangerLevel">Select Danger Level: </label>
                <select
                    id="dangerLevel"
                    value={dangerLevel}
                    onChange={handleChangeDangerLevel}
                >
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div>
                <div>
                    <label>
                        <input
                            type="checkbox"
                            checked={selectedLayers.route}
                            onChange={() => handleLayerChange('route')}
                        />
                        Route
                    </label>
                    <label>
                        <input
                            type="checkbox"
                            checked={selectedLayers.batiment}
                            onChange={() => handleLayerChange('batiment')}
                        />
                        Batiment
                    </label>
                    <label>
                        <input
                            type="checkbox"
                            checked={selectedLayers.sol}
                            onChange={() => handleLayerChange('sol')}
                        />
                        Sol
                    </label>
                </div>
                <Container maxWidth="lg" style={{ marginTop: '20px' }}>
                    <Grid container spacing={3}>
                        <Grid item xs={12}>
                            <Paper>
                                <Typography variant="h6" gutterBottom>
                                    Carte
                                </Typography>
                                <MapContainer center={antananarivoCoordinates} zoom={zoomLevel} style={{ height: '600px', width: '100%' }}>
                                    <TileLayer
                                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                                        attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                    />
                                    {markers.map(marker => {
                                        if (!isValidGeometry(marker.geom_text)) {
                                            console.warn(`Invalid geometry for marker with ID ${marker.id}:`, marker.geom_text);
                                            return null;  // Skip this marker
                                        }

                                        try {
                                            const geoJson = wellknown.parse(marker.geom_text);
                                            console.log('GeoJSON for marker:', geoJson);

                                            // Check if the geoJson is a MultiPolygon or Polygon and extract the positions accordingly
                                            const positions = geoJson.type === 'MultiPolygon' ?
                                                geoJson.coordinates[0][0].map(coord => [coord[1], coord[0]]) :
                                                geoJson.coordinates[0].map(coord => [coord[1], coord[0]]);

                                            return (
                                                <Polygon key={marker.id} positions={positions}>
                                                    <Popup>
                                                        <strong>{marker.region}</strong><br />
                                                        Fokontany: {marker.fokontany}<br />
                                                        Classement danger: {marker.cl_danger}
                                                    </Popup>
                                                </Polygon>
                                            );
                                        } catch (error) {
                                            console.error('Error parsing geometry:', error);
                                            return null;  // Skip this marker
                                        }
                                    })}
                                    {selectedLayers.route && (
                                        <WMSTileLayer
                                            key="route_layer"
                                            url="http://localhost:8080/geoserver/innondation/wms"
                                            layers="innondation:tana_route_inonder"
                                            format="image/png"
                                            transparent={true}
                                        />
                                    )}
                                    {selectedLayers.batiment && (
                                        <WMSTileLayer
                                            key="batiment_layer"
                                            url="http://localhost:8080/geoserver/innondation/wms"
                                            layers="innondation:batiment_inonder"
                                            format="image/png"
                                            transparent={true}
                                        />
                                    )}
                                    {selectedLayers.sol && (
                                        <WMSTileLayer
                                            key="sol_layer"
                                            url="http://localhost:8080/geoserver/innondation/wms"
                                            layers="innondation:sol"
                                            format="image/png"
                                            transparent={true}
                                        />
                                    )}
                                </MapContainer>
                            </Paper>
                        </Grid>
                    </Grid>
                </Container>
            </div>
        </div>
    );
};

export default MapComponent;
